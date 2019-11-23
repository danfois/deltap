<?php

namespace AppBundle\Controller\Vehicle;

use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\Vehicle\CarTaxType;
use AppBundle\Helper\Vehicle\CarTaxHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CarTaxController extends Controller
{
    /**
     * @Route("create-cartax", name="create_cartax")
     */
    public function createCarTaxAction()
    {
        $carTax = new CarTax();

        $form = $this->createForm(CarTaxType::class, $carTax);

        return $this->render('vehicles/car_taxes.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-cartax-ajax", name="create_cartax_ajax")
     */
    public function createCarTaxAjax(Request $request)
    {
        $carTax = new CarTax();
        $form = $this->createForm(CarTaxType::class, $carTax);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $carTax = $form->getData();

            $CTH = new CarTaxHelper($carTax, $em, false);
            $CTH->execute();
            $errors = $CTH->getErrors();

            if ($errors == null) {

                $em->persist($carTax);
                $em->flush();

                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
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
     * @Route("edit-cartax-{idCartax}", name="edit_cartax")
     */
    public function editCarTaxAction(Request $request, int $idCartax)
    {
        $carTax = $this->getDoctrine()->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $idCartax));
        if ($carTax == null) return new Response('Bollo non trovato', 404);

        $carTax->setStartDate($carTax->getStartDate()->format('d/m/Y'));
        $carTax->setEndDate($carTax->getEndDate()->format('d/m/Y'));

        $form = $this->createForm(CarTaxType::class, $carTax);

        return $this->render('vehicles/forms/car_tax_edit_form.html.twig', array(
            'form' => $form->createView(),
            'idCarTax' => $carTax->getCarTaxId()
        ));
    }

    /**
     * @Route("ajax/edit-cartax-{idCartax}", name="edit_cartax_ajax")
     */
    public function editCarTaxAjaxAction(Request $request, int $idCartax)
    {
        $em = $this->getDoctrine()->getManager();
        $carTax = $em->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $idCartax));
        if ($carTax == null) return new Response('Questo bollo non esiste', 404);

        $form = $this->createForm(CarTaxType::class, $carTax);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carTax = $form->getData();

            $IH = new CarTaxHelper($carTax, $em, true);
            $IH->execute();

            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Non sei autorizzato ad entrare in questa pagina');
    }

    /**
     * @Route("ajax/delete-cartax-{idCartax}", name="delete_cartax")
     */
    public function deleteCartaxAction(Request $request, int $idCartax)
    {
        $em = $this->getDoctrine()->getManager();
        $carTax = $em->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $idCartax));
        if ($carTax == null) return new Response('Bollo non trovato', 404);

        $vehicle = $em->getRepository(Vehicle::class)->findOneBy(array('currentCarTax' => $idCartax));

        if($vehicle != null) $vehicle->setCurrentCarTax(null);

        $em->remove($carTax);
        $em->flush();

        return new Response('OK', 200);
    }

    /**
     * @Route("ajax/renew-cartax", name="renew_cartax")
     */
    public function ajaxRenewCartaxAction(Request $request)
    {
        $carTaxArray = json_decode($request->request->get('ids'));
        $em = $this->getDoctrine()->getManager();

        foreach ($carTaxArray as $ca) {
            $c = $em->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $ca));
            if ($c instanceof CarTax) {
                $dateIntVal = $c->getStartDate()->diff($c->getEndDate());
                $ct = new CarTax();
                $ct->setStartDate($c->getStartDate()->add($dateIntVal));
                $ct->setEndDate($c->getEndDate()->add($dateIntVal));
                $ct->setPrice($c->getPrice());
                $ct->setVehicle($c->getVehicle());
                $ct->setIsActive(1);
                $em->persist($ct);
                $c->setIsActive(0);
                $c->getVehicle()->setCurrentCarTax($ct);
            }
        }
        $em->flush();

        return new Response('Bollo Rinnovato con Successo!', 200);
    }

    /**
     * @Route("set-active-car-tax", name="set_active_cartax")
     */
    public function setActiveCartax(Request $request)
    {
        $idC = $request->query->get('id');
        if(is_numeric($idC) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $cartax = $em->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $idC));

        if($cartax->getEndDate() < new \DateTime()) return new Response('Impossibile impostare come attivo poichè la data di fine validità è precedente a quella odierna', 500);

        $v = $cartax->getVehicle();
        $cs = $em->getRepository(CarTax::class)->findActiveCarTaxPerVehicle($v->getVehicleId());

        foreach($cs as $c) {
            $c->setIsActive(0);
        }

        $cartax->setIsActive(1);
        $v->setCurrentCarTax($cartax);

        $em->flush();
        return new Response('Bollo impostato come attivo!', 200);
    }

}