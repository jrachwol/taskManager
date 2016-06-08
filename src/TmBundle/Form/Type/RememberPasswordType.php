<?php

namespace TmBundle\Form\Type;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RememberPasswordType extends AbstractType {

    public function identity() {
        return new Response("true");
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'Twój email',
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email()
                )
            ))
            ->add('submitRem', SubmitType::class, array(
                'label' => 'Wyślij'
            ));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TmBundle\Entity\User',
            'validation_groups' => array('rememberPswd')

        ));
    }

}