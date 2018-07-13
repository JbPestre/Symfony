<?php

namespace CV\ProfilBundle\Form\CV;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class CVEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
  
       $builder
    ->remove('dateCrea')
    ->remove('ajouter')
    ->remove('blockLang')
    ->remove('blockComp')
    ->remove('blockExp')
    ->remove('blockForma')
    ->remove('blockLibre1')
    ->remove('blockLibre2')
    ->remove('posExp')
    ->remove('posLang')
    ->remove('posComp')
    ->remove('posForma')
    ->remove('posLibre1')
    ->remove('posLibre2')

    ->add('blockLang',     TextType::class, array(
     'label' => false,
))
    ->add('blockExp',     TextType::class, array(
     'label' => false,
))
    ->add('blockComp',     TextType::class, array(
     'label' => false,
))
    ->add('blockLibre1',     TextType::class, array(
     'label' => false,
))
     ->add('blockLibre2',     TextType::class, array(
     'label' => false,
))
    ->add('blockForma',     TextType::class, array(
     'label' => false,
))
    ->add('posLang', ChoiceType::class, array(
        'label' => false,

        'choices' => array(
            '0' => 0,'1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ), 
    ))

       ->add('posComp', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
            '0' => 0, '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),
    ))

       ->add('posExp', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
            '0' => 0, '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),
    ))

      ->add('posForma', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),
    ))

        ->add('posLibre1', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),
    ))

          ->add('posLibre2', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),
    ))
    ->add('modifier',      SubmitType::class,array('label' => 'Valider la modification'));

   
    }
    


    /**
     * {@inheritdoc}
     */
    public function getParent()
  {
    return CVType::class;
  }

}
