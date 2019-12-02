<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
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


            if($firstname != $_SESSION['firstname'])
            {
                $this -> UserRepository -> setFirstname($_SESSION['id'], $firstname);
            }
        }
        return $this->render('modifprofil.html.twig',['form' => $form -> createView()]);
    }
}