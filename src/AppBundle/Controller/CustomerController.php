<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Customer;
use AppBundle\Form\CreateCustomerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * @Route("create-customer", name="create_customer")
     */
    public function createCustomerAction()
    {
        $customer = new Customer();
        $form = $this->createForm(CreateCustomerType::class, $customer);

        return $this->render('customers/create_customer.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-customer-ajax", name="create_customer_ajax")
     */
    public function createCustomerAjaxAction(Request $request)
    {

    }
}