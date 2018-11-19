<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\CreateUserType;
use AppBundle\Helper\User\UserCreationHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

    /**
     * @Route("create-user-ajax", name="create_user_ajax")
     */
    public function createUserAjaxAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $encoder = $this->container->get('security.password_encoder');

            $UserHelper = new UserCreationHelper($user, $encoder);
            $UserHelper->execute();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return new Response('OK', 200);
    }

    /**
     * @Route("edit-user-{n}", name="edit_user")
     */
    public function editUserAction(int $n)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($n);
        if($user == null) return new Response('Utente non trovato', 404);

        $form = $this->createForm(CreateUserType::class, $user);

        return $this->render('users/create_user.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("users-list", name="users_list")
     */
    public function userListAction()
    {
        return $this->render('users/user_list.html.twig', array(
            'title' => 'Utenti',
            'new_button_name' => 'Nuovo Utente',
            'new_button_path' => $this->generateUrl('create_user')
        ));
    }
}