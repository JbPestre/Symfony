<?php

namespace CV\ProfilBundle\Form\CV;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperiencesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      ->add('annee',     TextType::class)
      ->add('nomSociete',     TextType::class)
      ->add('ville',     TextType::class,array('required' => false))
      ->add('poste',     TextType::class)
      ->add('descriptif',     TextAreaType::class,array('required' => false))
        ->add('tags', CollectionType::class, array(
        'entry_type'   => TagsType::class,
           'entry_options' => array('label' => false,'required' => false),
        'allow_add'    => true,
        'allow_delete' => true,
         'delete_empty' => true,
          'prototype_name' => '__name2__',
));
      }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\Experiences'
        ));
    }



}
