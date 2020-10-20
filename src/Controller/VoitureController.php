<?php
namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class VoitureController extends AbstractController
{


    /**
     * @var VoitureRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(VoitureRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        $this->em = $em;

    }
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

    /**
     * @route ("/voitures/{slug}-{id}", name="voiture.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show($slug,Voiture $voiture): Response
    {
        if ($voiture->getSlug() !== $slug){
            return $this->redirectToRoute('voiture.show', [
                'id' => $voiture->getId(),
                'slug' => $voiture->getSlug()
            ], 301);
        }
        return $this->render("Voiture/show.html.twig",[
            'voiture'=> $voiture,
            'current_menu' => 'voitures'
        ]);
    }
}