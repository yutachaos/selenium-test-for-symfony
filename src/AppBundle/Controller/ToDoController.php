<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ToDo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Todo controller.
 *
 * @Route("todo")
 */
class ToDoController extends Controller
{
    /**
     * Lists all toDo entities.
     *
     * @Route("/", name="todo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $toDos = $em->getRepository('AppBundle:ToDo')->findAll();

        return $this->render('todo/index.html.twig', array(
            'toDos' => $toDos,
        ));
    }

    /**
     * Creates a new toDo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $toDo = new Todo();
        $form = $this->createForm('AppBundle\Form\ToDoType', $toDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($toDo);
            $em->flush($toDo);

            return $this->redirectToRoute('todo_show', array('id' => $toDo->getId()));
        }

        return $this->render('todo/new.html.twig', array(
            'toDo' => $toDo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a toDo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     */
    public function showAction(ToDo $toDo)
    {
        $deleteForm = $this->createDeleteForm($toDo);

        return $this->render('todo/show.html.twig', array(
            'toDo' => $toDo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing toDo entity.
     *
     * @Route("/{id}/edit", name="todo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ToDo $toDo)
    {
        $deleteForm = $this->createDeleteForm($toDo);
        $editForm = $this->createForm('AppBundle\Form\ToDoType', $toDo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todo_edit', array('id' => $toDo->getId()));
        }

        return $this->render('todo/edit.html.twig', array(
            'toDo' => $toDo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a toDo entity.
     *
     * @Route("/{id}", name="todo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ToDo $toDo)
    {
        $form = $this->createDeleteForm($toDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($toDo);
            $em->flush();
        }

        return $this->redirectToRoute('todo_index');
    }

    /**
     * Creates a form to delete a toDo entity.
     *
     * @param ToDo $toDo The toDo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ToDo $toDo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('todo_delete', array('id' => $toDo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
