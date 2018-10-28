<?php

namespace AppBundle\Controller\Loan;
use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Form\Loan\LoanType;
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
}