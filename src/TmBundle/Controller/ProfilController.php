<?php

namespace TmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class ProfilController extends Controller {


    /**
     * @Route(
     *     "/success-profil",
     *     name = "success_profil_tm"
     * )
     * @Template()
     */
    public function successAction(Request $Request) {

        $user = $this->getUser();

        $repo = $this->getDoctrine()->getRepository('TmBundle:Success');

        $success = $repo->findByIdUser($user );

        return array(
            'success'=>$success
        );
    }

    /**
     * @Route(
     *     "/subscribe-profil",
     *     name = "subscribe_profil_tm"
     * )
     * @Template()
     */
    public function subscribeAction(Request $Request) {

        $user = $this->getUser();

        $tasks = $this->getDoctrine()->getManager()->getRepository('TmBundle:Subscribe');

        $rows = $tasks->findByIdUser($user);

        return array(
            'rows' => $rows,
        );
    }


    /**
     * @Route(
     *     "/statistic-profil",
     *     name = "statistic_profil_tm"
     * )
     * @Template()
     */
    public function statisticAction(Request $Request) {

        $conn = $this->get('database_connection');

            $user = $this->getUser()->getId();

            $task = $conn ->query('SELECT COUNT(id) FROM task WHERE autor ='.$user);
            $taskCount = $task ->fetch();

            $sub = $conn ->query('SELECT COUNT(id) FROM subscribe WHERE user_id ='.$user);
            $subCount = $sub ->fetch();

            $article = $conn ->query('SELECT COUNT(id) FROM wiki_article WHERE autor ='.$user);
            $articleCount = $article ->fetch();

            $finish = $conn ->query('SELECT COUNT(id) FROM success WHERE user_id ='.$user);
            $finCount = $finish->fetch();

        return array(
            'task'=>$taskCount,
            'subscribe'=>$subCount,
            'article'=>$articleCount,
            'success'=>$finCount
        );
    }


    /**
     * @Route(
     *     "/article-profil",
     *     name = "article_profil_tm"
     * )
     * @Template()
     */
    public function articleAction(Request $Request) {

        $idUser = $this->getUser();

        $article = $this->getDoctrine()->getRepository('TmBundle:WikiArticle');

        $rows = $article->findByAuthor($idUser);

        return array(
            'rows' => $rows
        );
    }

    
}