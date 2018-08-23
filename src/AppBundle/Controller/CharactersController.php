<?php

namespace AppBundle\Controller;

use AppBundle\Service\CharactersService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CharactersController extends Controller
{

    /**
     * @Route("/api/characters", name="characters")
     */
    public function indexAction(CharactersService $charactersService)
    {

        $characters = $charactersService->findAll();

        return $this->json($characters);
    }

}
