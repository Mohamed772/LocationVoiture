<?php
namespace App\Controller;

use App\Entity\Facturation;
use App\Entity\Voiture;
use App\Form\FacturationType;
use App\Repository\FacturationRepository;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

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
    /**
     * @var FacturationRepository
     */
    private $facturationRepository;

    public function __construct(VoitureRepository $repository, ObjectManager $em,FacturationRepository $facturationRepository){
        $this->repository = $repository;
        $this->em = $em;

        $this->facturationRepository = $facturationRepository;
    }

    /**
     * @Route("/voitures",name="voiture.index")
     * @param VoitureRepository $repository
     * @param FacturationRepository $facturationRepository
     * @return Response
     * @throws ORMException
     */
    public function index(VoitureRepository $repository,FacturationRepository $facturationRepository): Response
    {
        $facturationRepository->update();
        $voitures = $repository->findAllVisible();
        return $this->render("Voiture/index.html.twig",[
            'current_menu' => 'voitures',
            'voitures'=>$voitures
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

    /**
     * @route ("/voitures/{slug}-{id}/louer", name="voiture.louer", requirements={"slug": "[a-z0-9\-]*"})
     * @param Request $request
     * @param $slug
     * @param Voiture $voiture
     * @return Response
     */
    public function louer(Request $request, $slug,Voiture $voiture): Response
    {
        if ($voiture->getSlug() !== $slug){
            return $this->redirectToRoute('voiture.show', [
                'id' => $voiture->getId(),
                'slug' => $voiture->getSlug()
            ], 301);
        }


        $facture = new Facturation();
        $form = $this->createForm(FacturationType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $facture->setIdu($this->getUser());
            $facture->setIdv($voiture);
            $facture->setPrix(30* (int)date_diff($facture->getDateD() , $facture->getDateF())->format("%a"));
            $this->em->persist($facture);
            $this->em->flush();
            $this->addFlash('success','Facture créé avec succès');
            return $this->redirectToRoute('voiture.index');
        }
        return $this->render("user/louer.html.twig",[
            'form'=> $form->createView(),
            'facture'=> $facture,
            'voiture'=> $voiture
        ]);
    }
}