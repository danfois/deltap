<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Category;
use AppBundle\Entity\Customer;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\CreateCustomerType;
use AppBundle\Helper\Customer\CustomerHelper;
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

        //TODO: AGGIUNGERE AUTOFILL PER CERTI CAMPI

        $customer = new Customer();
        $category = new Category();

        $form = $this->createForm(CreateCustomerType::class, $customer);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('customers/create_customer.html.twig', array(
            'form' => $form->createView(),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("create-customer-ajax", name="create_customer_ajax")
     */
    public function createCustomerAjaxAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CreateCustomerType::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $customer = $form->getData();

            $CustomerHelper = new CustomerHelper($customer);
            $CustomerHelper->execute();

            $em->persist($customer);
            $em->flush();

            return new Response('Cliente creato con successo!', 200);
        }

        return new Response('Error', 500);
    }
}