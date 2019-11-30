<?php


namespace App\Controller;

use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class Inscription extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(InscriptionType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $User = $form->getData();
            $em->persist($User);
            $em->flush();

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