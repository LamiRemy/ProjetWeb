<?php


namespace App\Controller;

use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class Inscription extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(InscriptionType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isSubmitted())
        {
            $articles = $form -> getData();
            $em -> persist($articles);
            $em -> flush();

            return $this->redirectToRoute('inscriptionfaite');
        }

        return $this->render('inscription.html.twig',['title' => 'Inscription', 'form' => $form -> createView()]);
    }

    /**
     * @Route("/inscriptionfaite", name="inscriptionfaite")
     */
    public function InscriptionEnd()
    {
        return $this->render('inscriptionfaite.html.twig',['title' => 'Vous etes desormais inscris']);
    }
}