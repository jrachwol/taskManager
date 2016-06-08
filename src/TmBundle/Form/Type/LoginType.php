<?php

namespace TmBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class LoginType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Login'
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Hasło'
            ))
            ->add('remember_me', CheckboxType::class, array(
                'label' => 'Zapamiętaj mnie'
            ))
            ->add('saveLog', SubmitType::class, array(
                'label' => 'Zaloguj'
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TmBundle\Entity\User'
        ));
    }

}