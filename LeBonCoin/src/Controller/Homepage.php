<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\InscriptionType;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use Symfony\Component\Validator\Constraints\TimeValidator;

class Homepage extends AbstractController
{
    private $AnnonceRepository;

    public function __construct(AnnoncesRepository $annonceRepository)
    {
        $this->AnnonceRepository = $annonceRepository;
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function index()
    {
        $repository = $this -> getDoctrine() -> getRepository(Annonces::class);

        $Listeannonces = $repository -> findBy(array(),array('date' => 'desc'),5);

        return $this->render('homepage.html.twig', ['Pseudo' => $_SESSION['pseudo'], 'Listeannonces' => $Listeannonces]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(Request $request)
    {
        session_destroy();
        $request->getSession()->clear();
        return $this -> render('deconnexion.html.twig');
    }
}