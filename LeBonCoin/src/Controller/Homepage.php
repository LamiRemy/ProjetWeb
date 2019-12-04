<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
        return $this->render('homepage.html.twig', ['Pseudo' => $_SESSION['pseudo']]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion()
    {
        session_destroy();
        return $this -> render('deconnexion.html.twig');
    }

    /**
     * @Route("/ajouterannonce", name="ajouterannonce")
     */
    public function ajouteAnnonce(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnnonceType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $Annonce = $form ->getData();

            //$Annonce -> setName($form -> get('name') -> getData());
             //$Annonce->setDate(new \DateTime('now'));
           // $Annonce -> setDescription($form -> get('description') -> getData());
          //  $Annonce -> setLocation($form -> get('location') -> getData());
           // $Annonce -> setPrix($form -> get('prix') -> getData());
          //  $Annonce -> setCategory($form -> get('category') -> getData());
          //  $Annonce -> setState($form -> get('state') -> getData());
            $Annonce -> setUserId($_SESSION['id']);

            $em->persist($Annonce);
            $em->flush();
            return $this->redirectToRoute('homepage');

        }
        return $this->render('ajouterannonce.html.twig',['form' => $form->createView()]);
    }
}