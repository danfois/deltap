<?php

namespace AppBundle\Controller\Payment;
use AppBundle\Entity\Payment\BankAccount;
use AppBundle\Form\Payment\BankAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BankAccountController extends Controller
{
    /**
     * @Route("bank-accounts", name="bank_accounts")
     */
    public function bankAccountsAction()
    {
        $ba = new BankAccount();
        $form = $this->createForm(BankAccountType::class, $ba);

        $actionUrl = $this->generateUrl('create_bank_account');

        return $this->render('payments/bank_accounts.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-bank-account", name="create_bank_account")
     */
    public function createBankAccountAction(Request $request)
    {
        $ba = new BankAccount();
        $form = $this->createForm(BankAccountType::class, $ba);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ba = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($ba);
            $em->flush();

            return new Response('Conto Corrente creato con successo', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("edit-bank-account", name="edit_bank_account")
     */
    public function editBankAccount(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o conto corrente non trovato', 400);

        $ba = $this->getDoctrine()->getRepository(BankAccount::class)->findOneBy(array('bankAccountId' => $id));
        if($ba == null) return new Response('Conto Corrente non trovato', 404);

        $form = $this->createForm(BankAccountType::class, $ba);

        $actionUrl = $this->generateUrl('ajax_edit_bank_account', array('n' => $id));

        $html = $this->renderView('payments/forms/bank_account_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'edit' => 'true'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica Conto Corrente',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax-edit-bank-account-{n}", name="ajax_edit_bank_account")
     */
    public function ajaxEditBankAccount(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();
        $ba = $em->getRepository(BankAccount::class)->findOneBy(array('bankAccountId' => $n));

        if($ba == null) return new Response('Conto Corrente non trovato', 404);

        $form = $this->createForm(BankAccountType::class, $ba);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ba = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return new Response('Conto Corrente modificato con successo', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }
}