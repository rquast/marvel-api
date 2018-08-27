<?php

namespace AppBundle\Controller;

use AppBundle\Security\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $user = new User('uqrquast', ['ROLE_USER'], 'r.quast@uq.edu.au');
        return $this->json(['token' => $jwtManager->create($user)]);
    }

}
