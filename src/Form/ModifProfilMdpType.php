<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifProfilMdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password',PasswordType::class,['label' => 'Ancien mot de passe'])
            ->add('pseudo', RepeatedType::class ,['type' => PasswordType::class,'invalid_message'  =>'Les mots de passe ne correspondent pas', 'first_options' => ['label' => 'Nouveau mot de passe'], 'second_options' => ['label' => 'Répéter le mot de passe']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
