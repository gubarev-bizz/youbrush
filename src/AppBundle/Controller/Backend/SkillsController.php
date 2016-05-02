<?php

namespace AppBundle\Controller\Backend;

use Gedmo\Translatable\TranslatableListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\Skill;
use AppBundle\Form\SkillsType;

/**
 * Skills controller.
 *
 * @Route("/skills")
 */
class SkillsController extends Controller
{

    /**
     * Lists all Skills entities.
     *
     * @Route("/", name="youbrush_appbundle_admin_skills")
     * @Method("GET")
     * @Template("AppBundle:Admin/Skills:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Skills')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Skills entity.
     *
     * @Route("/", name="youbrush_appbundle_admin_skills_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/Skills:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Skills();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
		  	$em->setTranslatableLocale('ru_ru');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('youbrush_appbundle_admin_skills_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Skills entity.
     *
     * @param Skills $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Skills $entity)
    {
        $form = $this->createForm(new SkillsType(), $entity, array(
            'action' => $this->generateUrl('youbrush_appbundle_admin_skills_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Skills entity.
     *
     * @Route("/new", name="youbrush_appbundle_admin_skills_new")
     * @Method("GET")
     * @Template("AppBundle:Admin/Skills:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Skills();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Skills entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_skills_show")
     * @Method("GET")
     * @Template("AppBundle:Admin/Skills:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skills entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Skills entity.
     *
     * @Route("/{id}/edit", name="youbrush_appbundle_admin_skills_edit")
     * @Method("GET")
     * @Template("AppBundle:Admin/Skills:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skills entity.');
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
    * Creates a form to edit a Skills entity.
    *
    * @param Skills $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Skills $entity)
    {
        $form = $this->createForm(new SkillsType(), $entity, array(
            'action' => $this->generateUrl('youbrush_appbundle_admin_skills_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Skills entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_skills_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/Skills:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skills entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
		  	/** @var TranslatableListener $transListener */
		  	$transListener = $this->container->get('gedmo.listener.translatable');
		  	$em->setTranslatableLocale('ru_ru');
            $em->flush();

            return $this->redirect($this->generateUrl('youbrush_appbundle_admin_skills_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Skills entity.
     *
     * @Route("/{id}", name="youbrush_appbundle_admin_skills_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Skills')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Skills entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('youbrush_appbundle_admin_skills'));
    }

    /**
     * Creates a form to delete a Skills entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('youbrush_appbundle_admin_skills_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
