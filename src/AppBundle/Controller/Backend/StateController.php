<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\State;
use AppBundle\Form\StateType;

/**
 * State controller.
 *
 * @Route("/admin/state")
 */
class StateController extends Controller
{

    /**
     * Lists all State entities.
     *
     * @Route("/", name="youbrush_appbundle_admin_state_index")
     * @Method("GET")
     * @Template("AppBundle:Admin/State:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:State')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new State entity.
     *
     * @Route("/", name="youbrush_appbundle_admin_state_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/State:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new State();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('youbrush_appbundle_admin_state_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a State entity.
     *
     * @param State $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(State $entity)
    {
        $form = $this->createForm(new StateType(), $entity, array(
            'action' => $this->generateUrl('youbrush_appbundle_admin_state_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new State entity.
     *
     * @Route("/new", name="youbrush_appbundle_admin_state_new")
     * @Method("GET")
     * @Template("AppBundle:Admin/State:new.html.twig")
     */
    public function newAction()
    {
        $entity = new State();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a State entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_state_show")
     * @Method("GET")
     * @Template("AppBundle:Admin/State:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:State')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find State entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing State entity.
     *
     * @Route("/{id}/edit", name="youbrush_appbundle_admin_state_edit")
     * @Method("GET")
     * @Template("AppBundle:Admin/State:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:State')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find State entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a State entity.
    *
    * @param State $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(State $entity)
    {
        $form = $this->createForm(new StateType(), $entity, array(
            'action' => $this->generateUrl('youbrush_appbundle_admin_state_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing State entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_state_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/State:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:State')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find State entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('youbrush_appbundle_admin_state_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a State entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_state_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:State')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find State entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('youbrush_appbundle_admin_state_index'));
    }

    /**
     * Creates a form to delete a State entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('youbrush_appbundle_admin_state_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
