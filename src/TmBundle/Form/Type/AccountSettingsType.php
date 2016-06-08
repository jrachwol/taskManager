<?php

namespace TmBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class AccountSettingsType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
           ->add('username', TextType::class, array(
               'label' => 'Nick',
               'required' => FALSE
            ))
            ->add('avatarFile', FileType::class, array(
                'label' => 'Avatar'
            ))
            ->add('submitSetttings', SubmitType::class, array(
                'label' => 'Zapisz zmiany'
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TmBundle\Entity\User',
            'validation_groups' => array('settingAccount')
        ));
    }

}