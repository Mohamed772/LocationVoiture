<?php

namespace App\Controller\Admin;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\FacturationRepository;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVoituresController extends AbstractController{

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

    public function __construct(VoitureRepository $repository, ObjectManager $em, FacturationRepository $facturationRepository)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->facturationRepository = $facturationRepository;
    }

    /**
     * @Route("/admin", name="admin.index")
     * @return Response
     */
    public function index()
    {
        $voitures = $this->repository->findAll();
        $factures = $this->facturationRepository->findAll();
        return $this->render('admin/index.html.twig', ['voitures'=>$voitures,
            'factures'=>$factures
        ]);
    }

    /**
     * @Route("/admin/voiture/create", name="admin.voiture.new")
     */
    public function new(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->em->persist($voiture);
            $this->em->flush();
            $this->addFlash('success','Voiture créé avec succès');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/voiture/new.html.twig', [
            'voiture'=> $voiture,
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("/admin/voiture/{id}", name="admin.voiture.edit", methods="POST|GET")
     * @param Voiture $voiture
     * @param Request $request
     * @return Response
     */
    public function edit(Voiture $voiture, Request $request)
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Voiture modifié avec succès');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/voiture/edit.html.twig', [
            'voiture'=> $voiture,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/voiture/{id}", name="admin.voiture.delete",methods="DELETE")
     * @param Voiture $voiture
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Voiture $voiture, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $voiture->getId(), $request->get('_token'))){
            $this->em->remove($voiture);
            $this->em->flush();
            $this->addFlash('success','Voiture supprimé avec succès');
        }
        return $this->redirectToRoute('admin.index');
    }
}
