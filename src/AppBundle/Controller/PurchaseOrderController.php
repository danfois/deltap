<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use AppBundle\Form\PurchaseOrder\PurchaseOrderType;
use Symfony\Component\Routing\Annotation\Route;
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

    /**
     * @Route("edit-purchase-order-{n}", name="edit_purchase_order")
     */
    public function editPurchaseOrderAction(int $n)
    {
        $po = $this->getDoctrine()->getRepository(PurchaseOrder::class)->find($n);
        if($po == null) return new Response('Ordine di Acquisto non trovato', 404);

        $form = $this->createForm(PurchaseOrderType::class, $po);

        return $this->render('purchase_orders/purchase_order_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Ordine di Acquisto',
            'action_url' => $this->generateUrl('ajax_edit_purchase_order', array('n' => $n))
        ));
    }

    /**
     * @Route("ajax/edit-purchase-order-{n}", name="ajax_edit_purchase_order")
     */
    public function ajaxEditPurchaseOrder(Request $request, int $n)
    {
        $po = $this->getDoctrine()->getRepository(PurchaseOrder::class)->find($n);
        if($po == null) return new Response('Ordine di Acquisto non trovato', 404);

        $form = $this->createForm(PurchaseOrderType::class, $po);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $po = $form->getData();

            foreach($po->getPurchaseOrderDetails() as $d) {
                $d->setPurchaseOrder($po);
            }

            $em->flush();

            return new Response('Ordine di Acquisto modificato con successo!', 200);
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

    /**
     * @Route("purchase-order-list", name="purchase_order_list")
     */
    public function purchaseOrderListAction()
    {
        return $this->render('purchase_orders/purchase_order_list.html.twig');
    }
}