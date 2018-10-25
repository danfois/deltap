<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use AppBundle\Form\PurchaseOrder\PurchaseOrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PurchaseOrderController extends Controller
{
    /**
     * @Route("create-purchase-order", name="create_purchase_order")
     */
    public function createPurchaseOrderAction()
    {
        $po = new PurchaseOrder();
        $pod = new PurchaseOrderDetail();

        $po->addPurchaseOrderDetail($pod);

        $form = $this->createForm(PurchaseOrderType::class, $po);

        return $this->render('purchase_orders/purchase_order_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Creazione Ordine di Acquisto',
            'action_url' => $this->generateUrl('create_purchase_order_ajax')
        ));
    }

    /**
     * @Route("create-purchase-order-ajax", name="create_purchase_order_ajax")
     */
    public function createPurchaseOrderAjaxAction(Request $request)
    {
        $po = new PurchaseOrder();
        $form = $this->createForm(PurchaseOrderType::class, $po);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $po = $form->getData();

            foreach($po->getPurchaseOrderDetails() as $d) {
                $d->setPurchaseOrder($po);
            }

            $em->persist($po);
            $em->flush();

            return new Response('Ordine di Acquisto creato con successo!', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }
}