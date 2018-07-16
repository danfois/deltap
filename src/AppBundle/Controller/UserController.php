<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\CreateUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    /**
     * @Route("create-user", name="create_user")
     */
    public function createUserAction()
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);

        return $this->render('users/create_user.html.twig', array(
            'form' => $form->createView()
        ));
    }
}