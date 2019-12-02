<?php


namespace App\Controller;

use App\Form\InscriptionType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class Inscription extends AbstractController
{
    private $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->UserRepository = $userRepository;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $em,UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(InscriptionType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $User = $form->getData();

            $identifiant = $form->get('pseudo')->getData();

            $result = $this->UserRepository->inscription($identifiant);

            if (empty($result)) {
                //$User -> setPassword($encoder->encodePassword($User , $User -> getPassword()));
                $em->persist($User);
                $em->flush();
                return $this->redirectToRoute('inscriptionfaite');
            }
            else
            {
                return $this->render('inscriptionerror.html.twig', ['title' => 'Inscription', 'form' => $form->createView(), 'message' => 'Le pseudo est déjà utilisé']);
            }
        }

        return $this->render('inscription.html.twig',['title' => 'Inscription', 'form' => $form -> createView()]);
    }

    /**
     * @Route("/inscriptionfaite", name="inscriptionfaite")
     */
    public function InscriptionEnd()
    {
        return $this->render('inscriptionfaite.html.twig',[]);
    }
}