<?php

namespace TmBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use TmBundle\Entity\WikiArticle;
use TmBundle\Entity\WikiHistory;
use TmBundle\Form\Type\WikiArticleType;

class WikiController extends Controller {

    
/**
* @Route(
 *     "/show_article/{title}",
 *     name="wiki_show_article"
 * )
* @param wikiarticle $article
* @return \Symfony\Component\HttpFoundation\Response
*/

public function showArticleAction(WikiArticle $article=null) {
    if(!$article)  {
        return $this->render('TmBundle:Wiki:error_article_not_found.html.twig');
    }
    return $this->render('TmBundle:Wiki:wiki_article.html.twig',
        ['article' => $article]
    );
}

 /**
  * @Route(
  *     "/add-article",
  *     name="wiki_add_article"
  * )
  * @param Request $request
  */

public function addArticleAction(Request $request) {
    $article = new WikiArticle();
    $form = $this->createForm(WikiArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        if($form->get('preview')->isClicked()) {

        return $this->render('TmBundle:Wiki:wiki_article.html.twig', array(
            'article' => $article));
        }

        elseif($form->get('save')->isClicked()) {
            $user = $this->getUser();
            $article->setAuthor($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_page_tm');
        }

    }

    return $this->render('TmBundle:Wiki:add_article.html.twig', array(
        'form' => $form->createView()
    ));
}

    /**
    * @Route(
     *     "/edit-article/{title}",
     *     name="wiki_edit_article"
     * )
    * @param Request $request
    * @param wikiarticle $article
    * @return \Symfony\Component\HttpFoundation\Response
    */

public function editArticleAction(Request $request, WikiArticle $article=null) {
    if(!$article) {
        return $this->render('TmBundle:Wiki:error_article_not_found.html.twig');
    }

    $form = $this->createForm(WikiArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        if($form->get('preview')->isClicked()) {

            return $this->render('TmBundle:Wiki:wiki_article.html.twig', array(
            'article' => $article));
        }
        elseif($form->get('save')->isClicked()) {

            $history = new WikiHistory();
            $history->setUser($this->getUser())
            ->setWikiarticle($article)
            ->setDate(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->persist($history);
            $em->flush();

            return $this->redirectToRoute('article_page_tm');
        }

    }
    return $this->render('TmBundle:Wiki:add_article.html.twig', array(
    'form' => $form->createView()));
}

}
