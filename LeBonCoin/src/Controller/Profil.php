<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use App\Form\ModifProfilMdpType;
use App\Form\ModifProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Profil extends AbstractController
{
    private $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->UserRepository = $userRepository;
    }


    /**
     *@Route("/profil", name="profil")
     */
    public function index()
    {
        return $this->render('profil.html.twig',['Pseudo' => $_SESSION['pseudo'], 'Firstname' => $_SESSION['firstname'], 'Lastname' => $_SESSION['lastname'], 'Mail' => $_SESSION['mail'], 'Phone' => $_SESSION['phone']]);
    }

    /**
     *@Route("/modifprofil", name="modifprofil")
     */
    public function modifprofil(Request $request, EntityManagerInterface $em)
    {
        $form = $this -> createForm(ModifProfilType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $firstname = $form -> get('firstname') -> getData();
            $lastname = $form -> get('lastname') -> getData();
            $pseudo = $form -> get('pseudo') -> getData();
            $mail = $form -> get('mail') -> getData();
            $phone = $form -> get('phone') -> getData();
            $modif = 0;


            if($firstname != $_SESSION['firstname'])
            {
                $this -> UserRepository -> setFirstname($_SESSION['id'], $firstname);
                $_SESSION['firstname'] = $firstname;
                $modif = 1;
            }
            if($lastname != $_SESSION['lastname'])
            {
                $this -> UserRepository -> setLastname($_SESSION['id'], $lastname);
                $_SESSION['lastname'] = $lastname;
                $modif = 1;
            }
            if($pseudo != $_SESSION['pseudo'])
            {
                $result = $this->UserRepository->inscription($pseudo);

                if(empty($result))
                {
                    $this->UserRepository->setPseudo($_SESSION['id'], $pseudo);
                    $_SESSION['pseudo'] = $pseudo;
                    $modif = 1;
                }
                else
                {
                    return $this->render('modifprofilerror.html.twig',['form' => $form->createView(), 'message' => 'Le pseudo est déjà utilisé']);
                }
            }
            if($mail != $_SESSION['mail'])
            {
                $this->UserRepository->setMail($_SESSION['id'], $mail);
                $_SESSION['mail'] = $mail;
                $modif = 1;
            }
            if($phone != $_SESSION['phone'])
            {
                $this->UserRepository->setPhone($_SESSION['id'], $phone);
                $_SESSION['phone'] = $phone;
                $modif = 1;
            }

            if($modif == 1)
            {
                return $this->render('modifprofilfaite.html.twig',['form' => $form->createView(), 'message' => 'Les modification ont été enregistrées']);
            }
        }
        return $this->render('modifprofil.html.twig',['form' => $form -> createView()]);
    }

    /**
     *@Route("/modifmdp", name="modifmdp")
     */
    public function modifmdp(Request $request)
    {
        $form = $this -> createForm(ModifProfilMdpType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $lastpass = $form->get('password')->getData();
            $newpass = $form->get('pseudo')->getData();

            $result = $this->UserRepository->checkPassword($_SESSION['id'],$lastpass);

            if(empty($result))
            {
                return $this->render('modifmdperror.html.twig',['form' => $form -> createView(), 'Message' => 'L\'ancien mot de passe ne correspond pas']);
            }
            else
            {
                $this -> UserRepository -> setPass($_SESSION['id'],$newpass);
                return $this->render('modifmdpfait.html.twig',['form' => $form -> createView(), 'Message' => 'Le mot de passe a  bien été modifié']);
            }
        }

        return $this->render('modifmdp.html.twig',['form' => $form -> createView()]);
    }
}