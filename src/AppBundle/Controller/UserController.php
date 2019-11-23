<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\CreateUserType;
use AppBundle\Form\EmployeeToUser;
use AppBundle\Helper\User\UserCreationHelper;
use Symfony\Component\Routing\Annotation\Route;
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

        return new Response('Utente creato con successo', 200);
    }

    /**
     * @Route("edit-user-{n}", name="edit_user")
     */
    public function editUserAction(int $n)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($n);
        if($user == null) return new Response('Utente non trovato', 404);

        if($user->getStatus() == 1) {
            $user->setStatus(true);
        } else {
            $user->setStatus(false);
        }

        $form = $this->createForm(CreateUserType::class, $user);

        return $this->render('users/edit_user.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('edit_user_ajax', array('n' => $n))
        ));
    }

    /**
     * @Route("ajax-edit-user-{n}", name="edit_user_ajax")
     */
    public function editUserAjaxAction(Request $request, int $n)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($n);
        if($user == null) return new Response('Utente non trovato', 404);

        $em = $this->getDoctrine()->getManager();

        if($user->getStatus() == 1) {
            $user->setStatus(true);
        } else {
            $user->setStatus(false);
        }

        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $encoder = $this->container->get('security.password_encoder');
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            try {
                $em->flush();
            } catch( \Exception $e) {
                return new Response("Esiste già un utente con quei dati", 500);
            }

            return new Response('Utente modificato con successo', 200);
        } else {
            return new Response('Errore durante la modifica dell\'utente', 200);
        }
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

    /**
     * @Route("employee-to-user-{n}", name="employee_to_user")
     */
    public function employeeToUser(int $n)
    {
        $u = $this->getDoctrine()->getRepository(User::class)->find($n);
        if($u == null) return new Response('Utente non trovato', 404);

        $form = $this->createForm(EmployeeToUser::class, $u);

        $html = $this->renderView('users/employee_to_user.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_employee_to_user', array(
                'n' => $n
            ))
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Associa Dipendente a ' . $u->getUsername(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/employee-to-user-{n}", name="ajax_employee_to_user")
     */
    public function ajaxEmployeeToUser(Request $request, int $n)
    {
        $u = $this->getDoctrine()->getRepository(User::class)->find($n);
        if($u == null) return new Response('Utente non trovato', 404);

        $form = $this->createForm(EmployeeToUser::class, $u);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $u = $form->getData();

            $em->flush();
            return new Response('Dipendente associato con successo!', 200);
        }

        return new Response('Errore durante la associazione del dipendente', 500);
    }

    /**
     * @Route("change-user-status", name="change_user_status")
     */
    public function changeUserStatusAction(Request $request)
    {
        $id = $request->query->get('id');
        $status = $request->query->get('status');

        $possibleStatus = [0,1,2];

        if(!is_numeric($id) || $id == null || !in_array($status, $possibleStatus)) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository(User::class)->find($id);

        if($u == null) return new Response('Utente non trovato', 404);

        $u->setStatus($status);
        $em->flush();

        return new Response('Status modificato con successo', 200);
    }
}