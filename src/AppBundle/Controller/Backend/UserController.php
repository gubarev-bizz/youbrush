<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\User;
use AppBundle\Form\Backend\UserType;

/**
 * Backend\User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * Lists all Backend\User entities.
     *
     * @Route("/", name="admin_user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Backend\User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Backend\User entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Backend\User:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new User();
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_new'),
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $entity->setPassword($encoder->encodePassword($entity->getPlainPassword(), $entity->getSalt()));
                $entity->eraseCredentials();

                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Backend\User entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     * @Template("AppBundle:Backend\User:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Backend\User entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Method({"GET", "PUT"})
     * @Template("AppBundle:Backend\User:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\User entity.');
        }
        $form = $this->createForm(new UserType(), $entity, array(
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $entity->setPassword($encoder->encodePassword($entity->getPlainPassword(), $entity->getSalt()));
                $entity->eraseCredentials();
                $em->flush();

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
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
     * Deletes a Backend\User entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Backend\User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Backend\User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * Creates a form to delete a Backend\User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
