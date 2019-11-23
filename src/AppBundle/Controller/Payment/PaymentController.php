<?php

namespace AppBundle\Controller\Payment;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Form\Payment\PaymentType;
use AppBundle\Helper\Payment\PaymentCompiler;
use AppBundle\Helper\Payment\PaymentHelper;
use AppBundle\Util\ClassResolver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PaymentController extends Controller
{
    /**
     * @Route("create-payment", name="create_payment")
     */
    public function createPaymentAction()
    {
        $payment = new Payment();
        $payment->setPaymentDate(new \DateTime());
        $form = $this->createForm(PaymentType::class, $payment);

        return $this->render('payments/payment.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Registra Pagamento',
            'action_url' => $this->generateUrl('ajax_create_payment')
        ));
    }

    /**
     * @Route("ajax-create-payment", name="ajax_create_payment")
     */
    public function ajaxCreatePayment(Request $request)
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $PH = new PaymentHelper($payment, $em, false);
            $PH->execute();
            $errors = $PH->getErrors();

            if($errors == null) {
                $em->persist($payment);
                $em->flush();

                return new Response('Pagamento registrato con successo', 200);
            }
            return new Response($errors, 500);
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
     * @Route("edit-payment-{n}", name="edit_payment")
     */
    public function editPaymentAction(int $n)
    {
        $payment = $this->getDoctrine()->getRepository(Payment::class)->findOneBy(array('paymentId' => $n));
        if($payment == null) return new Response('Pagamento non trovato', 404);

        $form = $this->createForm(PaymentType::class, $payment);

        return $this->render('payments/payment.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Pagamento - N. ' . $payment->getPaymentId(),
            'action_url' => $this->generateUrl('ajax_edit_payment', array('n' => $n))
        ));
    }

    /**
     * @Route("ajax-edit-payment-{n}", name="ajax_edit_payment")
     */
    public function ajaxEditPaymentAction(Request $request, int $n)
    {
        $payment = $this->getDoctrine()->getRepository(Payment::class)->findOneBy(array('paymentId' => $n));
        if($payment == null) return new Response('Pagamento non trovato', 404);

        $form = $this->createForm(PaymentType::class, $payment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $PH = new PaymentHelper($payment, $em, true);
            $PH->execute();
            $errors = $PH->getErrors();

            if($errors == null) {
                $em->persist($payment);
                $em->flush();

                return new Response('Pagamento modificato con successo', 200);
            }
            return new Response($errors, 500);
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
     * @Route("create-payment-from/{type}/{n}", name="create_payment_from")
     */
    public function createPaymentFrom(string $type, int $n)
    {
        $class = ClassResolver::resolveClass($type);
        if($class === false) return new Response('Richiesta effettuata in maniera non corretta'. 400);

        $classData = $this->getDoctrine()->getRepository($class)->find($n);
        if($classData == null) return new Response('Dati non trovati', 404);

        $PaymentCompiler = new PaymentCompiler($classData);
        $payment = $PaymentCompiler->compile()->getPayment();

        $form = $this->createForm(PaymentType::class, $payment);

        return $this->render('payments/payment.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Registra Pagamento',
            'action_url' => $this->generateUrl('ajax_create_payment')
        ));
    }

    /**
     * @Route("payments-list", name="payments_list")
     */
    public function paymentsListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obm = $em->getRepository(Payment::class)->findTotalOutgoingBankMoney();
        $ibm = $em->getRepository(Payment::class)->findTotalIncomeBankMoney();
        $ocm = $em->getRepository(Payment::class)->findTotalOutgoingCashMoney();
        $icm = $em->getRepository(Payment::class)->findTotalIncomeCashMoney();
        $ot = $obm + $ocm;
        $it = $ibm + $icm;

        $totals = array('obm' => $obm, 'ibm' => $ibm, 'ocm' => $ocm, 'icm' => $icm, 'ot' => $ot, 'it' => $it);

        return $this->render('payments/payments_list.html.twig', array(
            'title' => 'Pagamenti',
            'totals' => $totals
        ));
    }

    /**
     * @Route("ajax/delete-payment-{n}", name="delete_payment")
     */
    public function deletePaymentAction(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();
        $payment = $em->getRepository(Payment::class)->findOneBy(array('paymentId' => $n));

        if($payment == null) return new Response('Pagamento non trovato', 404);

        $em->remove($payment);
        $em->flush();

        return new Response('Pagamento eliminato correttamente');
    }
}