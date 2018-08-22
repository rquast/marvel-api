<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CharactersController extends Controller
{

    /**
     * @Route("/api/characters", name="characters")
     */
    public function indexAction()
    {

        $response = [
            "data" => [
                [
                    "id" => 1234,
                    "type" => "character",
                    "attributes" => [
                        "name" => "One",
                        "description" => "Description One",
                        "modified" => date("c", time())
                    ]
                ],
                [
                    "id" => 1235,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Two",
                        "description" => "Description Two",
                        "modified" => date("c", time())
                    ]
                ],
                [
                    "id" => 1236,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Three",
                        "description" => "Description Three",
                        "modified" => date("c", time())
                    ]
                ],
                [
                    "id" => 1237,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Four",
                        "description" => "Description Four",
                        "modified" => date("c", time())
                    ]
                ]
            ]
        ];

        return $this->json($response);
    }

}
