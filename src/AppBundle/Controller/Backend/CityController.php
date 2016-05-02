<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\City;
use AppBundle\Form\Backend\CityType;

/**
 * Backend\City controller.
 *
 * @Route("/admin/city")
 */
class CityController extends Controller
{

    /**
     * Lists all Backend\City entities.
     *
     * @Route("/", name="admin_city")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Backend\City')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Backend\City entity.
     *
     * @Route("/new", name="admin_city_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Backend\City:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new City();
        $form = $this->createForm(new CityType(), $entity, array(
            'action' => $this->generateUrl('admin_city_new'),
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_city_show', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Backend\City entity.
     *
     * @Route("/{id}", name="admin_city_show")
     * @Method("GET")
     * @Template("AppBundle:Backend\City:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Backend\City entity.
     *
     * @Route("/{id}/edit", name="admin_city_edit")
     * @Method({"GET", "PUT"})
     * @Template("AppBundle:Backend\City:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\City entity.');
        }
        $form = $this->createForm(new CityType(), $entity, array(
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('admin_city_show', array('id' => $entity->getId())));
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
     * Deletes a Backend\City entity.
     *
     * @Route("/{id}", name="admin_city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Backend\City')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Backend\City entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_city'));
    }

    /**
     * Creates a form to delete a Backend\City entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_city_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
