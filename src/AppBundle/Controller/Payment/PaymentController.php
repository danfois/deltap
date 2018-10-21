<?php

namespace AppBundle\Controller\Payment;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Form\Payment\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    /**
     * @Route("create-payment", name="create_payment")
     */
    public function createPaymentAction()
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}