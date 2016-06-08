<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegisterUserType;
use AppBundle\Exception\UserException;


class RegisterController extends Controller {

    
    /**
     * @Route(
     *      "/register",
     *      name = "register_tm"
     * )
     * @Template()
     */
    public function registerAction(Request $request) {
        $user = new User();
        $registerUserForm = $this->createForm(RegisterUserType::class, $user);

            if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
                $registerUserForm->handleRequest($request);

                if ($registerUserForm->isValid()) {
                    try{
                        $userManager = $this->get('user_manager');
                        $userManager->registerUser($User);

                        $this->get('session')->getFlashBag()->add('success', 'Konto zostało utworzone. Na Twoją skrzynkę pocztową została wysłana wiadomość aktywacyjna.');

                    }
                    catch (UserException $exc) {
                        $this->get('session')->getFlashBag()->add('error', $exc->getMessage());
                    }
                }
                else {

                    $secondPswd = $registerUserForm->get('plainPassword')->get('second')->getData();

                    if(null == $secondPswd) {
                        $registerUserForm->get('plainPassword')->get('second')->addError(new FormError('Ta wartość nie powinna być pusta.'));
                    }
                    else {
                        $registerUserForm->get('plainPassword')->get('second')->addError(new FormError(''));
                    }

                    return [
                        'registerUserForm' => $registerUserForm->createView()
                    ];
                }

            }

        return [
            'registerUserForm' => $registerUserForm->createView()
        ];
    }


    /**
     * @Route(
     *      "/account-activation/{actionToken}",
     *      name = "user_activate_account"
     * )
     */
    public function activateAccountAction($actionToken) {

        try {

            $userManager = $this->get('user_manager');

            $userManager->activateAccount($actionToken);

            $this->get('session')->getFlashBag()->add('success', 'Twoje konto zostało aktywowane!');

        } catch (UserException $exc) {

            $this->get('session')->getFlashBag()->add('error', $exc->getMessage());
        }

        return $this->redirect($this->generateUrl('register_task_manager'));
    }

}