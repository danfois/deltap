<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use AppBundle\Form\PurchaseOrder\PurchaseOrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}