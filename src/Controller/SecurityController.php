<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Voiture;
use App\Form\UserType;
use App\Form\VoitureType;
use App\Repository\FacturationRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder,ObjectManager $em){
        $this->encoder = $encoder;
        $this->em = $em;
    }
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @param $slug
     * @param User $user
     * @return Response
     * @Route("/user/{slug}-{id}", name="user.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(FacturationRepository $facturationRepository,$slug,User $user): Response
    {
        if ($user->getSlug() !== $slug){
            return $this->redirectToRoute('user.show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ], 301);
        }

        $factures = $facturationRepository->findBy(['idu'=>$user->getId()]);
        return $this->render("user/show.html.twig",[
            'user'=> $user,
            'factures'=> $factures,
            'current_menu' => 'users'
        ]);
    }

    /**
     * @Route("/signup", name="signup")
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $user->setAdmin(false);
            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('security/signup.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}