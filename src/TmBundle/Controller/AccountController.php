<?php

namespace TmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;

use TmBundle\Form\Type\ChangePasswordType;
use TmBundle\Form\Type\AccountSettingsType;
use TmBundle\Form\Type\DataUserType;
use TmBundle\Form\Type\ThemeType;
use TmBundle\Entity\ThemeUser;
use TmBundle\Entity\DataUser;
use TmBundle\Exception\UserException;


class AccountController extends Controller {
    

    /**
     * @Route(
     *     "/settings",
     *     name = "settings_profil_tm"
     * )
     * @Template()
     */
    public function settingsAction(Request $request) {

        $user = $this->getUser();
        $accountSettingsForm = $this->createForm(AccountSettingsType::class, $user);
        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);

        if($request->isMethod('POST') && !$request->isXmlHttpRequest()) {

            $accountSettingsForm->handleRequest($request);

            if ($accountSettingsForm->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('user_account_tm'));

            }
        }

        if($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $changePasswordForm->handleRequest($request);

            if ($changePasswordForm->isValid()) {
                try {
                    $userManager = $this->get('user_manager');
                    $userManager->changePassword($user);
                    $this->get('session')->getFlashBag()->add('success', 'Twoje hasło zostało zmienione!');
                    return $this->redirect($this->generateUrl('settings_profil_tm'));
                }
                catch (UserException $exc) {
                    $this->get('session')->getFlashBag()->add('error', $exc->getMessage());
                }
            }
            else {
                $secondPswd = $changePasswordForm->get('plainPassword')->get('second')->getData();

                if(null == $secondPswd) {
                    $changePasswordForm->get('plainPassword')->get('second')->addError(new FormError('Ta wartość nie powinna być pusta.'));
                }
            }

        }

        return array(
            'user' => $user,
            'accountSettingsForm' => $accountSettingsForm->createView(),
            'changePasswordForm'=>$changePasswordForm->createView()
        );
    }


    /**
     * @Route(
     *     "/user-data/{id}",
     *     name = "data_profil_tm"
     * )
     * @Template()
     */
    public function dataUserAction(Request $request, $id) {

        $user = $this->getUser();

        $conn = $this->get('database_connection');
        $result = $conn ->query('SELECT * FROM data_user WHERE user_id ='.$id);
        $row = $result->fetch();

        if($row == NULL) {

            if($request->isXmlHttpRequest()) {

                $data = new DataUser();
                $form = $this->createForm(DataUserType::class, $data);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $data->setIdUser($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($data);
                    $em->flush();
                }
            }
        }
        else {

            if($request->isXmlHttpRequest()) {

                $repo = $this->getDoctrine()->getRepository('TmBundle:DataUser');
                $userId = $repo->findOneByIdUser($user);

                $form = $this->createForm(DataUserType::class, $userId);
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($userId);
                    $em->flush();
                }
            }

        }

        return array(
            'user'=>$user,
            'dataForm' => $form->createView()
        );
    }


    /**
     * @Route(
     *     "/theme-profil/{id}",
     *     name = "theme_app_tm"
     * )
     * @Template()
     */
    public function themeAction(Request $request, $id) {

        $user = $this->getUser();

        $repo = $this->getDoctrine()->getRepository('TmBundle:ThemeUser');
        $theme = $repo->findOneByIdUser($id);

        $themeForm = $this->createForm(ThemeType::class, $theme);
        $themeForm->handleRequest($request);

        if($request->isXmlHttpRequest()) {

            if($themeForm->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
            }
        }
        
        
        return array(
            'user'=>$user,
            'themeForm'=>$themeForm->createView()
        );
    }

    
}