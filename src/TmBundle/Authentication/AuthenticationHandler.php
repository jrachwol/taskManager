<?php

namespace TmBundle\Authentication;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;



class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {
    private $router;
    private $session;

    public function __construct( RouterInterface $router, Session $session ) {
        $this->router  = $router;
        $this->session = $session;

    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token ) {

        if ($request->isXmlHttpRequest()) {

            return new Response("auth-true");

        }
        else {

            if ( $this->session->get('_logout' ) ) {
                $url = $this->session->get( '_logout' );
            }
            else {
                $url = $this->router->generate( 'app_start_tm' );
            }
            return new RedirectResponse( $url );
        }
    }

    public function username(Request $request) {
        $username = $request->request->get('username');

        return new Response($username);
    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception) {

        if ($request->isXmlHttpRequest()) {

            $message = $request->getSession()->getFlashBag()->add('error', $exception->getMessage());

            $array = array( 'error' => $message );
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );

            return $response;

        }
        else {

            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

            return new RedirectResponse( $this->router->generate( 'login_tm' ) );
        }
    }
}