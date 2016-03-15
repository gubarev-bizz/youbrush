<?php
namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


/**
 * @Route("/admin")
 */
class AdminController extends Controller {

    /**
     * @Route("/", name="appbundle_admin_index")
     * @Method("GET")
     * @Template("AppBundle:Admin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findAll();
        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return [
            'users' => $user
        ];
    }

}