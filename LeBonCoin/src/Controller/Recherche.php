<?php


namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\InscriptionType;
use App\Form\ModifAnnonceType;
use App\Form\RechercheType;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use Symfony\Component\Validator\Constraints\TimeValidator;

class Recherche extends AbstractController
{
    private $AnnonceRepository;

    public function __construct(AnnoncesRepository $annoncesRepository)
    {
        $this->AnnonceRepository = $annoncesRepository;
    }

    /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(Request $request)
    {
        $form = $this->createForm(RechercheType::class);
        $form -> handleRequest($request);

        $word = $form->get('word')->getData();
        $prixmin = $form->get('prixmin')->getData();
        $prixmax = $form->get('prixmax')->getData();
        $category = $form->get('category')->getData();

        $repository = $this -> getDoctrine() -> getRepository(Annonces::class);

        if ($form->isSubmitted() && $form->isValid())
        {
            if(empty($word) && empty($prixmin) && empty($prixmax) && empty($category))
            {
                $Listeannonces = $repository -> findAll();
            }
            elseif(!empty($word) && empty($prixmin) && empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByWord($word);
            }
            elseif (empty($word) && !empty($prixmin) && empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMin($prixmin);
            }
            elseif (empty($word) && empty($prixmin) && !empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMax($prixmax);
            }
            elseif (empty($word) && empty($prixmin) && empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByCategory($category);
            }
            elseif(!empty($word) && !empty($prixmin) && empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByWordandMin($word,$prixmin);
            }
            elseif(!empty($word) && empty($prixmin) && !empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByWordandMax($word,$prixmax);
            }
            elseif(!empty($word) && empty($prixmin) && empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByWordandCat($word,$category);
            }
            elseif(empty($word) && !empty($prixmin) && !empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMinAndMax($prixmin,$prixmax);
            }
            elseif(empty($word) && !empty($prixmin) && empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMinAndCat($prixmin,$category);
            }
            elseif(empty($word) && empty($prixmin) && !empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMaxAndCat($prixmax,$category);
            }
            elseif(!empty($word) && !empty($prixmin) && !empty($prixmax) && empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByNameMinandMax($word,$prixmin,$prixmax);
            }
            elseif(!empty($word) && !empty($prixmin) && empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByNameMinandCat($word,$prixmin,$category);
            }
            elseif(!empty($word) && empty($prixmin) && !empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByNameMaxandCat($word,$prixmax,$category);
            }
            elseif(empty($word) && !empty($prixmin) && !empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByMinMaxandCat($prixmin,$prixmax,$category);
            }
            elseif(!empty($word) && !empty($prixmin) && !empty($prixmax) && !empty($category))
            {
                $Listeannonces = $this->AnnonceRepository->getByAll($word,$prixmin,$prixmax,$category);
            }
            return $this->render('rechercheresult.html.twig', ['form' => $form->createView(), 'Listeannonces' => $Listeannonces]);
        }


        return $this->render('recherche.html.twig',['form' => $form->createView()]);
    }
}