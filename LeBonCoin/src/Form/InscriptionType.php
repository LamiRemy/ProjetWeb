<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Encoder\EncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', NULL,['label'  => 'Prénom'])
            ->add('lastname',NULL,['label' => 'Nom'])
            ->add('pseudo',NULL,['label' => 'Pseudo'])
            ->add('password', RepeatedType::class ,['type' => PasswordType::class,'invalid_message' => 'Les mots de passe ne correspondent pas', 'first_options' => ['label' => 'Mot de passe'], 'second_options' => ['label' => 'Répéter le mot de passe']])
            ->add('mail',EmailType::class,['label' => 'Adresse mail'])
            ->add('phone',TelType::class,['label' => 'Numéro de téléphone'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
