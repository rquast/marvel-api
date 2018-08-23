<?php

namespace AppBundle\Service;


use AppBundle\Entity\Characters;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;

class MarvelApiService extends BaseService {

    const API_URL = "https://gateway.marvel.com/v1/public";
    const PUBLIC_KEY = "343972d2b5514521c8be01925d288091";
    const PRIVATE_KEY = "8746ec7a2e9557820c3b37db3098a71b57134bb3";

    /**
     * Performs a marvel api query first on cached data
     * then falling back to remote fetching from the marvel api
     *
     * @return array JSON API formatted results
     */
    public function query()
    {

        // Check for cached copy first
        $em = $this->container->get('doctrine')->getManager();
        $characterRepository = $em->getRepository(Characters::class);
        $results = $characterRepository->findAll();

        // If nothing cached, fetch data from marvel api
        if (!is_array($results) || sizeof($results) === 0) {
            $payload = null;
            $payload = $this->fetchData();
            if ($payload['code'] === 200) {
                // Save data returned form marvel api
                try {
                    $this->persistData($em, $payload['data']['results']);
                    $results = $characterRepository->findAll();
                } catch (OptimisticLockException $olex) {
                    $logger = $this->container->get('logger');
                    $logger->error($olex->getMessage());
                }
            }
        }

        // format the doctrine results in json api format for ember data
        return $this->formatPayloadAsJsonApi($results);

    }


    /**
     * Format doctrine results in json api format
     *
     * @param $results array Doctrine result set
     * @return array JSON API format for ember data
     */
    public function formatPayloadAsJsonApi($results)
    {

        $arr = [
            "data" => []
        ];

        /**
         * @var Characters $row
         */
        foreach ($results as $row) {
            $item = [
                "id" => $row->getId(),
                "type" => "character",
                "attributes" => [
                    "name" => $row->getName(),
                    "description" => $row->getDescription(),
                    "thumbnail" => $row->getThumbnail(),
                    "resource-uri" => $row->getResourceUri(),
                    "modified" => $row->getModified()
                ]
            ];
            $arr['data'][] = $item;
        }

        return $arr;

    }

    /**
     * @param EntityManager $em
     * @param array $payload
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistData(EntityManager $em, array $payload)
    {
        foreach ($payload as $row) {
            // Note: had to use "Characters" because "Character" is a reserved word in symfony.
            $character = new Characters();
            $character->setName($row['name']);
            $character->setDescription($row['description']);
            $character->setResourceUri($row['resourceURI']);
            $character->setThumbnail($row['thumbnail']['path'] . "." . $row['thumbnail']['extension']);
            $dt = new \DateTime($row['modified']);
            $character->setModified($dt);
            $em->persist($character);
        }

        $em->flush();
    }

    /**
     * Fetches marvel character data json
     *
     * @return mixed Marvel character data
     */
    public function fetchData()
    {
        $TS = time();
        $hash = md5($TS . MarvelApiService::PRIVATE_KEY . MarvelApiService::PUBLIC_KEY);

        // Note: for demo purposes, just basic fetching with file_get_contents instead of using guzzle http.
        return json_decode(file_get_contents(MarvelApiService::API_URL . "/characters?ts=" . $TS . "&apikey=" . MarvelApiService::PUBLIC_KEY . "&hash=" . $hash), true);
    }

}