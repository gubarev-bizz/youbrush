<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\State;
use AppBundle\Form\Backend\StateType;

/**
 * Backend\State controller.
 *
 * @Route("/state")
 */
class StateController extends Controller
{

    /**
     * Lists all Backend\State entities.
     *
     * @Route("/", name="admin_state")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Backend\State')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Backend\State entity.
     *
     * @Route("/new", name="admin_state_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Backend\State:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new State();
        $form = $this->createForm(new StateType(), $entity, array(
            'action' => $this->generateUrl('admin_state_new'),
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_state_show', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Backend\State entity.
     *
     * @Route("/{id}", name="admin_state_show")
     * @Method("GET")
     * @Template("AppBundle:Backend\State:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\State')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\State entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Backend\State entity.
     *
     * @Route("/{id}/edit", name="admin_state_edit")
     * @Method({"GET", "PUT"})
     * @Template("AppBundle:Backend\State:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\State')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\State entity.');
        }
        $form = $this->createForm(new StateType(), $entity, array(
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('admin_state_show', array('id' => $entity->getId())));
            }
        }

        $deleteForm = $this->createDeleteForm($id);


        return [
            'entity'      => $entity,
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ];

    }
    /**
     * Deletes a Backend\State entity.
     *
     * @Route("/{id}", name="admin_state_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Backend\State')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Backend\State entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_state'));
    }

    /**
     * Creates a form to delete a Backend\State entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_state_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
