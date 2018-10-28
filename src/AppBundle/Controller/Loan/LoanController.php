<?php

namespace AppBundle\Controller\Loan;
use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Form\Loan\LoanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}