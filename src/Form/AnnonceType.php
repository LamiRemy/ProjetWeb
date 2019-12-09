<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',NULL,['label' => 'Titre de l\'annonce'])
            ->add('description',NULL,['label' => 'Décrivez votre annonce'])
            ->add('prix',NumberType::class,['label' => 'Prix de vente', 'invalid_message'  =>'Le prix doit être un nombre'])
            ->add('state',ChoiceType::class,['choices' => ['Mauvais état' => 'Mauvais état','Bon état' => 'Bon état','Trés bon état' => 'Trés bon état','Neuf' => 'Neuf'],'label' => 'Etat du produit'])
            ->add('location',NULL,['label' => 'Adresse de vente'])
            ->add('category',ChoiceType::class,['choices' => ['Meubles' => 'Meubles','Jeux Video' => 'Jeux Video','Electromenager' => 'Electromenager','Véhicule' => 'Véhicule'],'label' => 'Categorie du produit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
