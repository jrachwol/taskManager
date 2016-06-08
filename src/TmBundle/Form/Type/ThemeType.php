<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ThemeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('theme', ChoiceType::class, array(
                'label'=>'Motyw',
                'choices'=>array(
                    'dark-grey'=>'dark-grey',
                    'dark-blue'=>'dark-blue',
                    'grey-orange'=>'grey-orange',
                    'white-mint'=>'white-mint',
                    'white-red'=>'white-red'
                )
            ))
            ->add('font', ChoiceType::class, array(
                'label'=>'Font',
                'choices'=>array(
                    'blue-white'=>'blue-white',
                    'green-white'=>'green-white',
                    'blue-dark'=>'blue-dark',
                    'green-dark'=>'green-dark',
                )
            ))
            ->add('background', ChoiceType::class, array(
                'label'=>'Tapeta',
                'choices'=>array(
                    'argyle'=>'argyle',
                    'binding_dark'=>'binding_dark',
                    'moulin'=>'moulin',
                    'black-Linen'=>'black-Linen',
                    'blackmamba'=>'blackmamba',
                    'blue'=>'blue',
                    'cartographer'=>'cartographer',
                    'dark-mosaic'=>'dark-mosaic',
                    'dark_wood'=>'dark_wood',
                    'fresh_snow'=>'fresh_snow',
                    'grey-bg'=>'grey-bg',
                    'navy-blue'=>'navy-blue',
                    'nice_snow'=>'nice_snow',
                    'olivia'=>'olivia',
                    'perforated_white_leather'=>'perforated_white_leather',
                    'pinstriped_suit'=>'pinstriped_suit',
                    'pixel-grey'=>'squares',
                    'wall'=>'wall',

                )
            ))
            ->add('saveTheme', SubmitType::class, array(
                'label'=>"Zapisz"
            ));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ThemeUser'
        ));
    }

}
