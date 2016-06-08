<?php
namespace TmBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DataUserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Imię'
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nazwisko'
            ))
            ->add('www', UrlType::class, array(
                'label' => 'www'
            ))
            ->add('phone', NumberType::class, array(
                'label' => 'Telefon'
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'O mnie'
            ))
            ->add('submitData', SubmitType::class, array(
                'label' => 'Zapisz'
            ));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TmBundle\Entity\DataUser'
        ));
    }

}
