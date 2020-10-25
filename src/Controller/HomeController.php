<?php
namespace App\Controller;

use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @Route("/",name="home")
     * @param VoitureRepository $repository
     * @return Response
     */
    public function index(VoitureRepository $repository): Response
    {
        $voitures = $repository->finLastest();
        return $this->render('pages/home.html.twig',['voitures'=>$voitures]);
    }

}