<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Expiration;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExpirationController extends Controller
{
    /**
     * @Route("set-expiration-status/{id}/{status}", name="set_expiration_status")
     */
    public function setExpirationStatusAction(int $id, $status)
    {
        $em = $this->getDoctrine()->getManager();
        $expiration = $em->getRepository(Expiration::class)->find($id);

        if($status != 1 && $status != 0) {
            return new Response("Status non valido", 400);
        }

        if($expiration == null) {
            return new Response("Scadenza non trovata", 404);
        }

        $expiration->setIsResolved((bool) $status);

        $em->flush();

        return new Response("Stato della scadenza modificato con successo", 200);
    }


    /**
     * @Route("delete-expiration-{id}", name="delete_expiration")
     */
    public function deleteExpirationAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $expiration = $em->getRepository(Expiration::class)->find($id);

        if($expiration == null) {
            return new Response("Scadenza non trovata", 404);
        }

        $em->remove($expiration);
        $em->flush();

        return new Response("Scadenza eliminata con successo", 200);
    }

    /**
     * @Route("expiring-invoices", name="expiring_invoice")
     */
    public function expiringInvoicesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $expirations = $em->getRepository(Expiration::class)->findExpiringInvoices();

        return $this->render('expirations/expiring_invoices.html.twig', array(
            'expirations' => $expirations,
            'currentDate' => new \DateTime()
        ));
    }
}