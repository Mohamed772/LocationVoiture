<?php

namespace App\Controller\Admin;


use App\Entity\Facturation;
use App\Form\FacturationTypeAllType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class AdminFacturationsController extends AbstractController{

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin/facturation/create", name="admin.facturation.new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $facture = new Facturation();
        $form = $this->createForm(FacturationTypeAllType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->em->persist($facture);
            $this->em->flush();
            $this->addFlash('success','facture créé avec succès');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/facturation/new.html.twig', [
            'facture'=> $facture,
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/admin/facturation/{id}", name="admin.facturation.edit" , methods="POST|GET")
     * @param Facturation $facture
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Facturation $facture, Request $request)
    {
        $form = $this->createForm(FacturationTypeAllType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Facturation modifié avec succès');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/facturation/edit.html.twig', [
            '$facture'=> $facture,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/facturation/{id}", name="admin.facturation.delete" , methods="DELETE")
     * @param Facturation $facture
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Facturation $facture, Request $request)
    {
        if($this->isCsrfTokenValid('deleteF'. $facture->getId(), $request->get('_token'))){
            $this->em->remove($facture);
            $this->em->flush();
            $this->addFlash('success','Facturation supprimé avec succès');
        }
        return $this->redirectToRoute('admin.index');
    }
}