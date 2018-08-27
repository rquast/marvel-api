<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\User;


class LoginController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function indexAction()
    {
        return $this->json([]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @Route("/login/do", name="login-do")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {

        // TODO: "validate" the username / password
        // $data = json_decode($request->getContent(), true);

        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $user = new User('uqrquast', ['ROLE_USER'], 'r.quast@uq.edu.au');
        return $this->json(['token' => $jwtManager->create($user)]);
    }

}
