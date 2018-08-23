<?php

namespace AppBundle\Service;


use AppBundle\Entity\Characters;

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
                $this->persistData($payload['data']['results']);
                $results = $characterRepository->findAll();
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
        return [];
    }

    /**
     * Persists retrieved marvel character data
     *
     * @param array $payload
     */
    public function persistData(array $payload)
    {
        foreach ($payload as $key => $value) {
            // echo $key . " - " . json_encode($value) . "\n";
        }
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
        return json_decode(file_get_contents(MarvelApiService::API_URL . "/characters?limit=10&offset=20&ts=" . $TS . "&apikey=" . MarvelApiService::PUBLIC_KEY . "&hash=" . $hash), true);
    }

}