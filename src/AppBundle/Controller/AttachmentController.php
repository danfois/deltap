<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\Attachment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AttachmentController extends Controller
{
    /**
     * @Route("download-attachment-{n}", name="download_attachment")
     */
    public function downloadAttachment(int $n)
    {
        $document = $this->getDoctrine()->getRepository(Attachment::class)->find($n);
        if ($document == null) return new Response('Nessun documento trovato', 404);

        $response = new BinaryFileResponse($document->getAbsolutePath());
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getName());
        return $response;
    }
}