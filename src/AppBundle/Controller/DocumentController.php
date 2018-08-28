<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DocumentController extends Controller
{
    /**
     * @Route("download-document/{id}", name="download_document")
     */
    public function downloadDocumentAction(Request $request, int $id)
    {
        $document = $this->getDoctrine()->getRepository(Document::class)->findOneBy(array('documentId' => $id));
        if ($document == null) return new Response('Nessun documento trovato', 404);

        $response = new BinaryFileResponse($document->getAbsolutePath());
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getName());
        return $response;
    }

    /**
     * @Route("delete-document", name="delete_document")
     */
    public function deleteDocumentAction(Request $request)
    {
        $id = $request->query->get('id');
        if (is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o nessun documento trovato', 400);

        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository(Document::class)->findOneBy(array('documentId' => $id));
        if ($document == null) return new Response('Nessun documento da cancellare trovato', 404);

        try {
            if (unlink($document->getAbsolutePath())) {

                $em->remove($document);
                $em->flush();

                return new Response('Documento rimosso con successo!', 200);
            }
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione del file',500);
        }
        return new Response('Impossibile cancellare il file', 500);
    }
}