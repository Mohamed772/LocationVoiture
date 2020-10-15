<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class VoitureController
{
    /**
     * @Route("/voitures",name="voiture.index")
     * @return Response
     */
    public function index(): Response
    {
        return new Response('les voitures');
    }
}