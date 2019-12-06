<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\InscriptionType;
use App\Form\ModifAnnonceType;
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
        $Annonce = $this -> getDoctrine() -> getRepository(Annonces::class) -> find($id);
        $User = $this -> getDoctrine() -> getRepository(User::class) -> find($Annonce->getUserId());

        $_SESSION['Annonce'] = $id;
        $_SESSION['AnnonceName'] = $Annonce->getName();
        $_SESSION['AnnonceDescription'] = $Annonce->getDescription();
        $_SESSION['AnnoncePrix'] = $Annonce->getPrix();
        $_SESSION['AnnonceEtat'] = $Annonce->getState();
        $_SESSION['AnnonceAdresse'] = $Annonce->getLocation();
        $_SESSION['AnnonceCategory'] = $Annonce->getCategory();

        if($User->getId() == $_SESSION['id'])
        {
            $Propriétaire = true;
        }
        else
        {
            $Propriétaire = false;
        }

        return $this -> render('annonce.html.twig',[
            'Name' => $Annonce->getName(),
            'Description' => $Annonce->getDescription(),
            'Prix' => $Annonce->getPrix(),
            'Date' => $Annonce->getDate(),
            'State' => $Annonce->getState(),
            'Lieu' => $Annonce->getLocation(),
            'Vendeur' => $User->getPseudo(),
            'Phone' => $User->getPhone(),
            'Mail' => $User->getMail(),
            'Proprietaire' => $Propriétaire,
            'ID' => $_SESSION['Annonce']
        ]);
    }

    /**
     * @Route("/modifannonce{id}", name="modifannonce")
     */
    public function modifannonce(Request $request, EntityManagerInterface $em, $id)
    {
        $form = $this->createForm(ModifAnnonceType::class);
        $form -> handleRequest($request);

        $Annonce = $em -> getRepository(Annonces::class) -> find($id);

        if ($form->isSubmitted() && $form->isValid())
        {
            $modif = 0;

            if($form->get('name')->getData() != $Annonce->getName())
            {
                $Annonce->setName($form->get('name')->getData());
                $_SESSION['AnnonceName'] = $form->get('name')->getData();
                $modif = 1;
                $em -> flush();
            }

            if($form->get('description')->getData() != $Annonce->getDescription())
            {
                $Annonce->setDescription($form->get('description')->getData());
                $modif = 1;
                $em -> flush();
            }

            if($form->get('prix')->getData() != $Annonce->getPrix())
            {
                $Annonce->setPrix($form->get('prix')->getData());
                $modif = 1;
                $em -> flush();
            }

            if($form->get('state')->getData() != $Annonce->getState())
            {
                $Annonce->setState($form->get('state')->getData());
                $modif = 1;
                $em -> flush();
            }

            if($form->get('location')->getData() != $Annonce->getLocation())
            {
                $Annonce->setLocation($form->get('location')->getData());
                $modif = 1;
                $em -> flush();
            }

            if($form->get('category')->getData() != $Annonce->getCategory())
            {
                $Annonce->setCategory($form->get('category')->getData());
                $modif = 1;
                $em -> flush();
            }

            if($modif == 1)
            {
                return $this->render('modifannoncefaite.html.twig',['form' => $form->createView(), 'message' => 'Les modification ont été enregistrées', 'ID' => $_SESSION['Annonce']]);
            }
        }

        return $this->render('modifannonce.html.twig',['form' => $form->createView(),'ID' => $_SESSION['Annonce']]);
    }


    /**
     * @Route("/supprimerannonce{id}", name="supprimerannonce")
     */
    public function supprimerannonce($id, EntityManagerInterface $em)
    {
        $Annonce = $em -> getRepository(Annonces::class) -> find($id);

        $em -> remove($Annonce);
        $em -> flush();

        return $this -> render('supprimerannoncefait.html.twig');
    }
}