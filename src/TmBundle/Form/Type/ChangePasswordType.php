<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangePasswordType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('currentPassword', PasswordType::class, array(
                'label' => 'Stare hasło',
                'mapped' => false,
                'constraints' => array(
                    new UserPassword(array(
                        'message' => 'Stare hasło nie jest poprawne'
                    ))
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Nowe hasło'
                ),
                'second_options' => array(
                    'label' => 'Powtórz hasło'
                )
            ))
            ->add('submitPswd', SubmitType::class, array(
                'label' => 'Zmień hasło'
            ));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('Default','changePassword')
        ));
    }

}