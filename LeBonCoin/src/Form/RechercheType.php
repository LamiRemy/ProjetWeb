<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word',NULL,['label' => 'Rechercher par mot clé', 'required' => false])
            ->add('prixmin',NumberType::class,['label' => 'Prix minimum', 'invalid_message'  =>'Le prix minimum doit être un nombre', 'required' => false])
            ->add('prixmax',NumberType::class,['label' => 'Prix maximum', 'invalid_message'  =>'Le prix maximum doit  être un nombre', 'required' => false])
            ->add('category',ChoiceType::class,['choices' => ['Meubles' => 'Meubles','Jeux Video' => 'Jeux Video','Electromenager' => 'Electromenager','Véhicule' => 'Véhicule'],'label' => 'Rechercher par categorie', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
