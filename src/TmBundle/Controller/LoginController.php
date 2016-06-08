<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;

use AppBundle\Exception\UserException;
use AppBundle\Entity\User;
use AppBundle\Form\Type\LoginType;
use AppBundle\Form\Type\RememberPasswordType;

class LoginController extends Controller {

    /**
     * @Route(
     *     "/login",
     *     name = "login_tm"
     * )
     * @Template()
     */
    public function loginAction(Request $request) {

        $loginForm = $this->createForm(LoginType::class);
        $remPassType = $this->createForm(RememberPasswordType::class);

        if($request->isMethod("POST") && $request->isXmlHttpRequest()) {

            $remPassType->handleRequest($request);

            if($remPassType->isValid()) {

                try {
                    $userEmail = $remPassType->get('email')->getData();

                    $userManager = $this->get('user_manager');

                    $userManager->sendResetPasswordLink($userEmail);

                    $this->get('session')->getFlashBag()->add('success', 'Instrukcje resetowania hasła zostały wysłane na adres e-mail.');

                }
                catch (UserException $exc) {
                    $error = new FormError($exc->getMessage());
                    $remPassType->get('email')->addError($error);

                    return [
                        'loginForm'=>$loginForm->createView(),
                        'remPassType'=>$remPassType->createView()
                    ];
                }
            }
        }

        return [
            'loginForm'=>$loginForm->createView(),
            'remPassType'=>$remPassType->createView()
        ];

    }

// New password 

    /**
     * @Route(
     *      "/reset-password/{actionToken}",
     *      name = "user_reset_password"
     * )
     */

    public function resetPasswordAction($actionToken) {
        try {

            $userManager = $this->get('user_manager');

            $userManager->resetPassword($actionToken);

            $this->get('session')->getFlashBag()->add('success', 'Na Twój adres e-mail zostało wysłane nowe hasło!');
        }

        catch (Exception $exc) {
            $this->get('session')->getFlashBag()->add('error', $exc->getMessage());
        }

        return $this->redirect($this->generateUrl('login_task_manager'));
    }

}