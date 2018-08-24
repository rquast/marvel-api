<?php

namespace AppBundle\Controller;

use AppBundle\Service\CharactersService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class CharactersController extends Controller
{

    /**
     * @param CharactersService $charactersService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @Route("/api/characters", name="characters")
     */
    public function indexAction(CharactersService $charactersService)
    {
        $characters = $charactersService->findAll();
        return $this->json($characters);
    }

    /**
     * @param $id string Character ID
     * @param $request Request request object
     * @param CharactersService $charactersService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @Route("/api/characters/{id}", name="update-characters")
     * @Method("PATCH")
     */
    public function updateAction($id, Request $request, CharactersService $charactersService)
    {
        $data = json_decode($request->getContent(), true);
        $character = $charactersService->update($id, $data);
        return $this->json($character);
    }

}
