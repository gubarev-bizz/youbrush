<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\Country;
use AppBundle\Form\Backend\CountryType;

/**
 * Backend\Country controller.
 *
 * @Route("/country")
 */
class CountryController extends Controller
{

    /**
     * Lists all Backend\Country entities.
     *
     * @Route("/", name="admin_country")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Backend\Country')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Backend\Country entity.
     *
     * @Route("/new", name="admin_country_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Backend\Country:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new Country();
        $form = $this->createForm(new CountryType(), $entity, array(
            'action' => $this->generateUrl('admin_country_new'),
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_country_show', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Backend\Country entity.
     *
     * @Route("/{id}", name="admin_country_show")
     * @Method("GET")
     * @Template("AppBundle:Backend\Country:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\Country')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\Country entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Backend\Country entity.
     *
     * @Route("/{id}/edit", name="admin_country_edit")
     * @Method({"GET", "PUT"})
     * @Template("AppBundle:Backend\Country:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\Country')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\Country entity.');
        }
        $form = $this->createForm(new CountryType(), $entity, array(
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('admin_country_show', array('id' => $entity->getId())));
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
     * Deletes a Backend\Country entity.
     *
     * @Route("/{id}", name="admin_country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Backend\Country')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Backend\Country entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_country'));
    }

    /**
     * Creates a form to delete a Backend\Country entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_country_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
