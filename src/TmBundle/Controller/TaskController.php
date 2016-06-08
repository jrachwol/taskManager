<?php

namespace AppBundle\Controller;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

use AppBundle\Form\Type\TaskType;
use AppBundle\Entity\Task;
use AppBundle\Entity\Subscribe;
use AppBundle\Entity\Success;

class TaskController extends Controller {

// Add Task

    /**
     * @Route(
     *      "/add-task",
     *     name="add_task_tm"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */

    public function addTaskAction(Request $request) {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->getUser();
                $task->setAuthor($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('task_page_tm');
            }
            else {
                return array(
                    'form' => $form->createView()
                );
            }
        }
        return array(
            'form' => $form->createView()
        );

    }

// Edit Task

    /**
     * @Route(
     *     "edit-task/{id}",
     *     name="edit_task_tm"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function editTaskAction(Request $request, $id) {

        $repo = $this->getDoctrine()->getRepository('AppBundle:Task');
        $task = $repo->find($id);

        if(null == $task) {
            throw $this->createNotFoundException('Takie zadanie nie istnieje');
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            return $this->redirect($this->generateUrl('task_page_tm', array(
                'id' => $task->getId()
            )));

        }
        return array(
            'task' => $task,
            'form' => $form->createView()
        );

    }
    
//Remove Task

    /**
     * @Route(
     *    "/remove_task/{id}",
     *    name="remove_task_tm"
     * )
     * @Template()
     */

    public function removeTaskAction(Request $request, $id) {

        if($request->isXmlHttpRequest()) {

            try {
                $repo = $this->getDoctrine()->getRepository('AppBundle:Task');
                $obj = $repo->find($id);
                $em = $this->getDoctrine()->getManager();
                $em->remove($obj);
                $em->flush();

                return new Response('remove-true');
            }
            catch (ForeignKeyConstraintViolationException $exc) {

                $this->get('session')->getFlashBag()->add('error', 'Nie można usunąć subskrypowanego zadania');
                // dodać komunikat o niemożliwości usunięcia zrealizowanego zadania
                return $this->redirect($this->generateUrl('task_page_tm'));

            }

        }

        return $this->redirect($this->generateUrl('task_page_tm'));

    }

// Subscribe

    /**
     * @Route(
     *    "/subscribe-task/{task}",
     *    name="subscribe_task_tm"
     * )
     */
    public function subscribeTaskAction(Request $request, $task) {

        if($request->isXmlHttpRequest()) {

            $user = $this->getUser()->getId();

            $conn = $this->get('database_connection');
            $querySub = $conn ->query('SELECT * FROM subscribe WHERE user_id ='.$user.' AND task_id='.$task);
            $querySucc = $conn->query('SELECT * FROM success WHERE user_id ='.$user.' AND task_id='.$task);
            $rowSub = $querySub->fetch();
            $rowSucc = $querySucc->fetch();

            if($rowSub != null) {
                $this->get('session')->getFlashBag()->add('error', 'Nie śpij. Już subskrypujesz to zadanie !');
                return $this->redirectToRoute('task_page_tm');

            }
            if($rowSucc != null) {
                $this->get('session')->getFlashBag()->add('error', 'Nie powielaj kodu już wykonałeś to zadanie');
                return $this->redirectToRoute('task_page_tm');

            }
            if($request->isXmlHttpRequest()) {

                $repo = $this->getDoctrine()->getRepository('AppBundle:Task');
                $task = $repo->find($task);
                $user = $this->getUser();

                $sub = new Subscribe();
                $sub->setIdUser($user);
                $sub->setIdTask($task);

                $em = $this->getDoctrine()->getManager();
                $em->persist($sub);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Subskrypujesz nowe zadanie !');

            }

        }

        return $this->redirectToRoute('task_page_tm');

    }

// Unsubscribe

    /**
     * @Route(
     *    "/unsubscribe-task/{task}",
     *    name="unsubscribe_task_tm"
     * )
     */
    public function unsubscribeTaskAction(Request $request, $task) {

        if($request->isXmlHttpRequest()) {

            $repo = $this->getDoctrine()->getRepository('AppBundle:Subscribe');
            $em = $this->getDoctrine()->getManager();
            $sub = $repo->find($task);
            $em->remove($sub);
            $em->flush();
            $this->get('session')->getFlashBag()->add('error', 'Subskrypcja anulowana');
        }

        return $this->redirect($this->generateUrl('subscribe_profil_tm'));
    }

// Success-task

    /**
     * @Route(
     *      "/success-task/{id}",
     *      name="success_task_tm"
     * )
     */
    public function successAction(Request $request, $id) {

        $idUser = $this->getUser()->getId();
        $conn = $this->get('database_connection');
        $result = $conn ->query('SELECT * FROM success WHERE user_id='.$idUser.' AND id_subscribe ='.$id);
        $row = $result->fetch();

        if($row != null) {
            $this->get('session')->getFlashBag()->add('error', 'Już zakończyłeś to zadanie');
            return $this->redirect($this->generateUrl('subscribe_profil_tm'));
        }
        if($request->isXmlHttpRequest()) {

            $repoSub = $this->getDoctrine()->getRepository('AppBundle:Subscribe');
            $sub = $repoSub->find($id);
            $task = $sub->getIdTask();
            $user = $sub->getIdUser();

            $success = new Success();

            $success->setIdUser($user);
            $success->setIdTask($task);
            $success->setIdSubscribe($id);

            $em = $this->getDoctrine()->getManager();
            $em->persist($success);
            $em->remove($sub);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Gratulujemy ukończenia zadania');
            
        }

        return $this->redirect($this->generateUrl('subscribe_profil_tm'));

    }
}
