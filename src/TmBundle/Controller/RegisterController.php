<?php

namespace TmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;

use TmBundle\Entity\User;
use TmBundle\Entity\ThemeUser;
use TmBundle\Entity\DataUser;
use TmBundle\Form\Type\RegisterUserType;
use TmBundle\Exception\UserException;


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
        $data = new DataUser();
        $theme = new ThemeUser();

        $registerUserForm = $this->createForm(RegisterUserType::class, $user);

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $registerUserForm->handleRequest($request);

            if ($registerUserForm->isValid()) {
                try{
                    $userManager = $this->get('user_manager');
                    $userManager->registerUser($user);

                    $theme->setIdUser($user);
                    $theme->setTheme('dark-grey');
                    $theme->setFont('blue-white');
                    $theme->setBackground('binding_dark');

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($theme);
                    $em->flush();

                    $data->setIdUser($user);
                    $data->setName(null);
                    $data->setLastName(null);
                    $data->setPhone(null);
                    $data->setWww(null);
                    $data->setAbout(null);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($data);
                    $em->flush();

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