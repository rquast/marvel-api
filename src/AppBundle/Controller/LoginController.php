<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\User;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function indexAction()
    {
        return $this->json(['TODO: implement a web login form to generate a token.']);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     *
     * @Route("/login/do", name="login-do")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        if (isset($data['username']) && isset($data['password'])) {
            // "Validating" the username and password :)
            if ($data['username'] === 'uqrquast' && $data['password'] === 'password') {
                $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
                $user = new User('uqrquast', ['ROLE_USER'], 'r.quast@uq.edu.au');
                return $this->json(['token' => $jwtManager->create($user)]);
            }
        }

        $array = array('success' => false);
        $response = new Response(json_encode($array), 401);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

}
