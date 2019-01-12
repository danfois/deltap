<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TicklerController extends Controller
{
    /**
     * @Route("tickler", name="tickler")
     */
    public function ticklerAction()
    {
        return $this->render('tickler/tickler.html.twig');
    }
}