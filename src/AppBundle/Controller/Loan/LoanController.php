<?php

namespace AppBundle\Controller\Loan;
use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Form\Loan\LoanInstalmentType;
use AppBundle\Form\Loan\LoanType;
use AppBundle\Helper\Loan\InstalmentCompiler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoanController extends Controller
{
    /**
     * @Route("create-loan", name="create_loan")
     */
    public function createLoanAction()
    {
        $loan = new Loan();
        $li = new LoanInstalment();
        $loan->addLoanInstalment($li);

        $form = $this->createForm(LoanType::class, $loan);

        return $this->render('loans/loan.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Crea Mutuo',
            'action_url' => $this->generateUrl('ajax_create_loan')
        ));
    }

    /**
     * @Route("ajax-create-loan", name="ajax_create_loan")
     */
    public function ajaxCreateLoanAction(Request $request)
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $loan = $form->getData();

            foreach($loan->getLoanInstalments() as $l) {
                $l->setLoan($loan);
            }

            $em->persist($loan);
            $em->flush();

            return new Response('Mutuo Creato con successo!', 200);
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
     * @Route("edit-loan-{n}", name="edit_loan")
     */
    public function editLoanAction(int $n)
    {
        $loan = $this->getDoctrine()->getRepository(Loan::class)->find($n);
        if($loan == null) return new Response('Mutuo non trovato', 404);

        $form = $this->createForm(LoanType::class, $loan);

        return $this->render('loans/loan.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Mutuo - ' . $loan->getLoanNumber(),
            'action_url' => $this->generateUrl('ajax_edit_loan', array('n' => $n))
        ));
    }

    /**
     * @Route("ajax/edit-loan-{n}", name="ajax_edit_loan")
     */
    public function ajaxEditLoanAction(Request $request, int $n)
    {
        $loan = $this->getDoctrine()->getRepository(Loan::class)->find($n);
        if($loan == null) return new Response('Mutuo non trovato', 404);

        $form = $this->createForm(LoanType::class, $loan);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $loan = $form->getData();

            foreach($loan->getLoanInstalments() as $l) {
                $l->setLoan($loan);
            }

            $em->flush();

            return new Response('Mutuo Modificato con successo!', 200);
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
     * @Route("loan-list", name="loan_list")
     */
    public function loanListAction()
    {
        return $this->render('loans/loan_list.html.twig');
    }

    /**
     * @Route("create-instalment", name="create_instalment")
     */
    public function createInstalmentAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $loan = $this->getDoctrine()->getRepository(Loan::class)->find($id);
        if($loan == null) return new Response('Mutuo non trovato', 404);

        $InstalmentCompiler = new InstalmentCompiler($loan);
        $instalment = $InstalmentCompiler->compile()->getInstalment();

        $form = $this->createForm(LoanInstalmentType::class, $instalment, array('addingInstalmentOnly' => true));

        $html = $this->renderView('loans/instalment_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_create_instalment')
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Aggiungi rata a mutuo ' . $loan->getLoanNumber(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/create-instalment", name="ajax_create_instalment")
     */
    public function ajaxCreateInstalmentAction(Request $request)
    {
        $instalment = new LoanInstalment();
        $form = $this->createForm(LoanInstalmentType::class, $instalment, array('addingInstalmentOnly' => true));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $instalment = $form->getData();

            $em->persist($instalment);
            $em->flush();

            return new Response('Rata creata con succcesso', 200);
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