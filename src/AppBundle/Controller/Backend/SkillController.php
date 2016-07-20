<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Backend\Translations\SkillTranslation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Backend\Skill;
use AppBundle\Form\Backend\SkillType;

/**
 * Backend\Skill controller.
 *
 * @Route("/admin/skill")
 */
class SkillController extends Controller
{

    /**
     * Lists all Backend\Skill entities.
     *
     * @Route("/", name="admin_skill")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Backend\Skill')->findAll();

        dump($this->getRequest()->getLocale());

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Backend\Skill entity.
     *
     * @Route("/new", name="admin_skill_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Backend\Skill:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new Skill();
        $form = $this->createForm(new SkillType(), $entity, array(
            'action' => $this->generateUrl('admin_skill_new'),
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_skill_show', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Backend\Skill entity.
     *
     * @Route("/{id}", name="admin_skill_show")
     * @Method("GET")
     * @Template("AppBundle:Backend\Skill:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Backend\Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\Skill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Backend\Skill entity.
     *
     * @Route("/{id}/edit", name="admin_skill_edit")
     * @Method({"GET", "PUT"})
     * @Template("AppBundle:Backend\Skill:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Skill $entity */
        $entity = $em->getRepository('AppBundle:Backend\Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Backend\Skill entity.');
        }
        $form = $this->createForm(new SkillType(), $entity, array(
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entity->addTranslation(new SkillTranslation($request->getLocale(), 'title', 'Maistas'));
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_skill_show', array('id' => $entity->getId())));
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
     * Deletes a Backend\Skill entity.
     *
     * @Route("/{id}", name="admin_skill_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Backend\Skill')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Backend\Skill entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_skill'));
    }

    /**
     * Creates a form to delete a Backend\Skill entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_skill_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
