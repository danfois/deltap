<?php

namespace AppBundle\Controller\Invoice;

use AppBundle\Entity\Invoice\InvoiceDetail;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Form\Invoice\IssuedInvoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    /**
     * @Route("/issue-invoice", name="issue_invoice")
     */
    public function issueInvoice()
    {
        $invoice = new IssuedInvoice();
        $detail = new InvoiceDetail();
        $invoice->addInvoiceDetail($detail);
        $form = $this->createForm(IssuedInvoiceType::class, $invoice);

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}