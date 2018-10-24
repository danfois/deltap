<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Provider;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\ProviderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProviderController extends Controller
{
    /**
     * @Route("create-provider", name="create_provider")
     */
    public function createProviderAction()
    {
        $provider = new Provider();
        $category = new Category();

        $form = $this->createForm(ProviderType::class, $provider);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('providers/provider.html.twig', array(
            'title' => 'Crea Fornitore',
            'action_url' => $this->generateUrl('create_provider_ajax'),
            'form' => $form->createView(),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("create-provider-ajax", name="create_provider_ajax")
     */
    public function createProviderAjax(Request $request)
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $provider = $form->getData();
            $provider->setRegistrationDate(new \DateTime);

            $em->persist($provider);
            $em->flush();

            return new Response('Fornitore creato con successo!', 200);
        }

        return new Response('Errore', 500);
    }

    /**
     * @Route("edit-provider-{n}", name="edit_provider")
     */
    public function editProvider(int $n)
    {
        $provider = $this->getDoctrine()->getRepository(Provider::class)->find($n);
        if($provider == null) return new Response('Fornitore non trovato', 404);

        $category = new Category();

        $form = $this->createForm(ProviderType::class, $provider);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('providers/provider.html.twig', array(
            'title' => 'Modifica Fornitore',
            'action_url' => $this->generateUrl('ajax_edit_provider', array('n' => $n)),
            'form' => $form->createView(),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("ajax/edit-provider-{n}", name="ajax_edit_provider")
     */
    public function ajaxEditProvider(Request $request, int $n)
    {
        $provider = $this->getDoctrine()->getRepository(Provider::class)->find($n);
        if($provider == null) return new Response('Fornitore non trovato', 404);

        $form = $this->createForm(ProviderType::class, $provider);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $provider = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return new Response('Fornitore modificato con successo', 200);
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