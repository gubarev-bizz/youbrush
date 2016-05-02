<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Backend\User;
use AppBundle\Form\AuthorizationType;
use AppBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;



class SecurityController extends Controller {

    /**
     * @Route("/login", name="_security_login")
     * @Method("GET")
     * @Template("AppBundle:Security:login.html.twig")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(new AuthorizationType(), NULL, [
            'action' => $this->generateUrl('_security_check')
        ]);
        $form->add('submit', 'submit', [
            'label' => 'Login',
            'attr' => ['class' => 'btn btn-default']
        ]);

        return [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/registration", name="appbundle_registration")
     * @Method("GET")
     * @Template("AppBundle:Security:registration.html.twig")
     */
    public function registrationAction()
    {
        $user = new User();
        $formRegistration = $this->createUserCreateForm($user);

        return [
            'formRegistration' => $formRegistration->createView()
        ];
    }

    /**
     * @Route("/registration/create", name="appbundle_registration_create")
     * @Method("POST")
     * @Template("AppBundle:Security:registration.html.twig")
     */
    public function registrationCreateAction(Request $request)
    {
        $user = new User();
        $formRegistration = $this->createUserCreateForm($user);
        $formRegistration->handleRequest($request);
        if($formRegistration->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setStatus(0);
            $user->setType('user');

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->eraseCredentials();

            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_index'));
        }

        return [
            'entity' => $user,
            'formRegistration' => $formRegistration->createView()
        ];
    }

    /**
     * @param User $user
     * @return \Symfony\Component\Form\Form
     */
    private function createUserCreateForm(User $user) {
        $form = $this->createForm(new RegistrationType(), $user, array(
            'action' => $this->generateUrl('appbundle_registration_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', [
            'label' => 'Complete Sign Up',
            'attr' => ['class' => 'btn btn-default']
        ]);

        return $form;
    }

}