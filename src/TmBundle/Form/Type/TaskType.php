<?php

namespace TmBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, array(
                'label'=>"Tytuł"
            ))
            ->add('description', TextareaType::class, array(
                'label'=>"Opis"
            ))
            ->add('level', ChoiceType::class, array(
                'label'=>'Poziom',
                'choices'=>array(
                    'basic'=>'basic',
                    'advanced'=>'advanced',
                    'master'=>'master'
                )
            ))
            ->add('save', SubmitType::class, array(
                'label'=>"Zapisz"
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TmBundle\Entity\Task'
        ));
    }

}
