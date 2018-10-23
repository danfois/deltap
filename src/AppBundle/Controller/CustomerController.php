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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CustomerController extends Controller
{
    /**
     * @Route("create-customer", name="create_customer")
     */
    public function createCustomerAction()
    {
        $customer = new Customer();
        $category = new Category();

        $form = $this->createForm(CreateCustomerType::class, $customer);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('customers/customer.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Creazione Cliente',
            'action_url' => $this->generateUrl('create_customer_ajax'),
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

        return new Response('Errore', 500);
    }

    /**
     * @Route("edit-customer-{n}", name="edit_customer")
     */
    public function editCustomerAction(int $n)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($n);
        if($customer == null) return new Response('Cliente non trovato', 404);

        $category = new Category();

        $form = $this->createForm(CreateCustomerType::class, $customer);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('customers/customer.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Cliente',
            'action_url' => $this->generateUrl('ajax_edit_customer', array('n' => $n)),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("ajax/edit-customer-{n}", name="ajax_edit_customer")
     */
    public function ajaxEditCustomerAction(Request $request, int $n)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($n);
        if($customer == null) return new Response('Cliente non trovato', 404);

        $form = $this->createForm(CreateCustomerType::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return new Response('Cliente modificato con successo', 200);
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