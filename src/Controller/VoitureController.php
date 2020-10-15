<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voitures",name="voiture.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("Voiture/index.html.twig",[
            'current_menu' => 'voitures'
            ]);
    }
}