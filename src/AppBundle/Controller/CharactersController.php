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
        // dirty hack because symfony sucks and won't let you set cors in a config.
        header("Access-Control-Allow-Origin: *");

        $response = [
            "data" => [
                [
                    "id" => 1234,
                    "type" => "character",
                    "attributes" => [
                        "name" => "One",
                        "description" => "Description One"
                    ]
                ],
                [
                    "id" => 1235,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Two",
                        "description" => "Description Two"
                    ]
                ],
                [
                    "id" => 1236,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Three",
                        "description" => "Description Three"
                    ]
                ],
                [
                    "id" => 1237,
                    "type" => "character",
                    "attributes" => [
                        "name" => "Four",
                        "description" => "Description Four"
                    ]
                ]
            ]
        ];

        return $this->json($response);
    }

}
