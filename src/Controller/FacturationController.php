<?php
namespace App\Controller;

use App\Entity\Facturation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FacturationController extends AbstractController{

    /**
     * @Route ("/facturation/{slug}-{id}", name="facturation.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show($slug,Facturation $facturation): Response
    {
        if ($facturation->getSlug() !== $slug){
            return $this->redirectToRoute('facturation.show', [
                'id' => $facturation->getId(),
                'slug' => $facturation->getSlug()
            ], 301);
        }
        return $this->render("Facturation/show.html.twig",[
            'facturation'=> $facturation,
            'current_menu' => 'voitures'
        ]);
    }

}