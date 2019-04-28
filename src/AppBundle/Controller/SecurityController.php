<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils) {

        //utilità di autenticazione predefinite in symfony
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', array(
            'error' => $error
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/drivers/login/redirect", name="login_redirect")
     */
    public function loginRedirectAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            return $this->redirectToRoute('login');
            // throw $this->createAccessDeniedException();
        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('homepage');
        }
        else if($this->get('security.authorization_checker')->isGranted('ROLE_DRIVER'))
        {
            return $this->redirectToRoute('daily_orders');
        }
        else
        {
            return $this->redirectToRoute('login');
        }
    }
}