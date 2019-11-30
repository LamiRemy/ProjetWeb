<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\ConnexionType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Connexion extends AbstractController
{
    private $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->UserRepository = $userRepository;
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(ConnexionType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $identifiant = $form -> get('pseudo') -> getData();
            $mdp = $form -> get('password') -> getData();
            $User = $form -> getData();

            $pass = $encoder->encodePassword($User , $mdp);

            echo $pass;

            $result = $this->UserRepository->connexion($identifiant, $pass);

            /*if(empty($result))
            {
                echo "nop";
            }
            else
            {
                echo "yep";
            }

            /*if($result != 0)
            {
                $_SESSION['id'] = $result -> getId();
                return $this->redirectToRoute('connexionfaite');
            }
            else
            {
                throw $this->createNotFoundException('Aucun compte avec le pseudo '. $identifiant);
            }*/
        }

        return $this->render('connexion.html.twig',['title' => 'Connexion', 'form' => $form -> createView()]);
    }

    /**
     * @Route("/connexionfaite", name="connexionfaite")
     */
    public function ConnexionEnd()
    {
        return $this->render('connexionfaite.html.twig',['title' => 'Vous etes desormais connecté']);
    }
}