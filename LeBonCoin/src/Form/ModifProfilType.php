<?php

namespace App\Form;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', NULL,['label'  => 'Prénom', 'data' => $_SESSION['firstname']])
            ->add('lastname',NULL,['label' => 'Nom', 'data' => $_SESSION['lastname']])
            ->add('pseudo',NULL,['label' => 'Pseudo', 'data' => $_SESSION['pseudo']])
            ->add('mail',EmailType::class,['label' => 'Adresse mail', 'data' => $_SESSION['mail']])
            ->add('phone',TelType::class,['label' => 'Numéro de téléphone', 'data' => $_SESSION['phone']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
