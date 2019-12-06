<?php

namespace App\Form;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModifAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',NULL,['label' => 'Titre de l\'annonce', 'data' => $_SESSION['AnnonceName']])
            ->add('description',NULL,['label' => 'Décrivez votre annonce', 'data' => $_SESSION['AnnonceDescription']])
            ->add('prix',NumberType::class,['label' => 'Prix de vente', 'invalid_message'  =>'Le prix doit être un nombre', 'data' => $_SESSION['AnnoncePrix']])
            ->add('state',ChoiceType::class,['choices' => ['Mauvais état' => 'Mauvais état','Bon état' => 'Bon état','Trés bon état' => 'Trés bon état','Neuf' => 'Neuf'], 'data' => $_SESSION['AnnonceEtat']])
            ->add('location',NULL,['label' => 'Adresse de vente', 'data' => $_SESSION['AnnonceAdresse']])
            ->add('category',ChoiceType::class,['choices' => ['Meubles' => 'Meubles','Jeux Video' => 'Jeux Video','Electromenager' => 'Electromenager','Véhicule' => 'Véhicule'], 'data' => $_SESSION['AnnonceCategory']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
