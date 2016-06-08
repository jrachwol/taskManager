<?php

namespace TmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

// Start

    /**
     * @Route(
     *     "/",
     *     name="app_start_tm"
     * )
     * @Template
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function appStartAction() {

        return [];
    }

// Task

    /**
     * @Route("/task-page",
     *     name="task_page_tm"
     * )
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function taskPageAction(Request $request) {

        $tasks = $this->getDoctrine()->getRepository('TmBundle:Task')->findAll();

        return [
            'tasks' => $tasks,
            'styles' => $this->getStyles()
        ];

    }

// Article

    /**
     * @Route(
     *     "/article-page",
     *     name="article_page_tm"
     * )
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function articlePageAction(Request $request) {

        $article = $this->getDoctrine()->getRepository('TmBundle:WikiArticle')->findAll();

        return [
            'article' => $article,
            'styles' => $this->getStyles()
        ];
    }

// Profil

    /**
     * @Route(
     *     "/user-profil",
     *     name = "user_profil_tm"
     * )
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilAction(Request $request) {

        $user = $this->getUser();

        $data = $this->getDoctrine()->getRepository('TmBundle:DataUser');
        $userData = $data->findOneByIdUser($user);

        return [
            'user' => $user,
            'styles' => $this->getStyles(),
            'userData' => $userData
        ];
    }


// Message

    /**
     * @Route(
     *     "/user-message",
     *     name = "user_message_tm"
     * )
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messageAction(Request $request) {

        return [
            'styles' => $this->getStyles()
        ];
    }

// Account

    /**
     * @Route(
     *     "/user-account",
     *     name = "user_account_tm"
     * )
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accountAction(Request $request) {

        $user = $this->getUser();

        return [
            'user' => $user,
            'styles' => $this->getStyles()
        ];
    }


// Styles

    public function getStyles() {

        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TmBundle:ThemeUser');
        $theme = $repo->findOneByIdUser($user);
        return $theme;
    }

// Flash Message

    /**
     * @Route(
     *      "/flash-message",
     *      name = "flash_message_tm"
     * )
     */

    public function templateAction() {

        return $this->render("TmBundle:Template:flashMsg.html.twig");
    }

}
