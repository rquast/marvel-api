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

        /*

        Return Example:

            {
                "authenticator": "authenticator:jwt",
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicGFzc3dvcmQiOiJhYmMxMjMiLCJpYXQiOjE1MzUzMzA5MjUsImV4cCI6MTUzNTMzNDczM30.6ARxNzS198wvGz8RR8T80Zk00SEAryGhiHarx6S2fCs",
                "exp": 1535334733,
                "tokenData": {
                    "username": "admin",
                    "password": "abc123",
                    "iat": 1535330925,
                    "exp": 1535334733
                }
            }

         */


        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $user = new User('uqrquast', ['ROLE_USER'], 'r.quast@uq.edu.au');
        return $this->json(['token' => $jwtManager->create($user)]);



        // $data = json_decode($request->getContent(), true);
        // return $this->json($data);
    }

}
