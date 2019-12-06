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

class Annonce extends AbstractController
{
    /**
     * @Route("/ajouterannonce", name="ajouterannonce")
     */
    public function ajouteAnnonce(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnnonceType::class);
        $form -> handleRequest($request);

        $User = $this->getDoctrine() -> getRepository(User::class) -> find($_SESSION['id']);

        if ($form->isSubmitted() && $form->isValid())
        {
            $Annonce = $form ->getData();

            $Annonce -> setUserId($User);

            $em->persist($Annonce);
            $em->flush();
            return $this->redirectToRoute('ajouterannoncefaite');

        }
        return $this->render('ajouterannonce.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/ajouterannoncefaite", name="ajouterannoncefaite")
     */
    public function ajouterannoncefaite()
    {
        return $this->render('ajouterannoncefaite.html.twig');
    }

    /**
     * @Route("/annonce{id}", name="annonce")
     */
    public function annonce($id)
    {

    }
}