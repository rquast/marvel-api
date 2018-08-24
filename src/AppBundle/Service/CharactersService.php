<?php

namespace AppBundle\Service;

use AppBundle\Entity\Characters;
use Doctrine\ORM\EntityManager;


class CharactersService extends BaseService {

    public function findAll()
    {
        $marvelApiService = new MarvelApiService();
        $marvelApiService->setContainer($this->container);
        return $marvelApiService->query();
    }

    public function update($id, $data) {

        /**
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();
        $characterRepository = $em->getRepository(Characters::class);
        $character = $characterRepository->find($id);
        $character->setFavourite($data['data']['attributes']['favourite']);
        $em->persist($character);

        $em->flush();

        return [
            "data" => [
                "type" => "character",
                "id" => $id,
                "attributes" => [
                    "name" => $character->getName(),
                    "description" => $character->getDescription(),
                    "thumbnail" => $character->getThumbnail(),
                    "resource-uri" => $character->getResourceUri(),
                    "favourite" => $character->isFavourite(),
                    "modified" => $character->getModified()
                ]
            ]
        ];
    }

}