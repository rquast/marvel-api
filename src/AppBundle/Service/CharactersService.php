<?php

namespace AppBundle\Service;


class CharactersService extends BaseService {

    public function findAll()
    {
        $marvelApiService = new MarvelApiService();
        $marvelApiService->setContainer($this->container);
        return $marvelApiService->query();
    }

}