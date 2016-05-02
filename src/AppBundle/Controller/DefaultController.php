<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage", host="%domain%")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return ['a' => 21];
    }

    /**
     * @Route("/", name="userHomepage", host="{userSlug}.%domain%")
     * @ParamConverter("user", class="AppBundle:Backend\User", options={"id" = "userSlug"})
     */
    public function userIndexAction(Request $request, $user)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
