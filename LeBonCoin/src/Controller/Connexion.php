<?php

namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use App\Form\ConnexionType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Connexion extends AbstractController
{
    private $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->UserRepository = $userRepository;
    }

    /**
     * @Route("/", name="connexion")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(ConnexionType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $identifiant = $form -> get('pseudo') -> getData();
            $mdp = $form -> get('password') -> getData();

            //$User = $form -> getData();

            //$pass = $encoder->encodePassword($User , $mdp);

            $result = $this->UserRepository->connexion($identifiant, $mdp);

            if(empty($result))
            {
                return $this->render('connexionerror.html.twig',['form' => $form -> createView(), 'message' => 'Mot de passe ou pseudo incorrecte']);
            }
            else
            {
                $firstname = $this->UserRepository->getFirstname($identifiant);
                $lastname = $this->UserRepository->getLastname($identifiant);
                $mail = $this->UserRepository->getMail($identifiant);
                $phone = $this->UserRepository->getPhone($identifiant);
                $id = $this->UserRepository->getId($identifiant);

                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['mail'] = $mail;
                $_SESSION['phone'] = $phone;
                $_SESSION['pseudo'] = $identifiant;
                $_SESSION['id'] = $id;
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('connexion.html.twig',['form' => $form -> createView()]);
    }
}