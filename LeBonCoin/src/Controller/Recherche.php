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

class Recherche
{
    /**
     * @Route("/recherche", name="recherche")
     */
}