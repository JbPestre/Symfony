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


class CVType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      ->add('intitule',     TextType::class)

      ->add('descriptif',     TextAreaType::class)

      ->add('blocLibre1',     CKEditorType::class, array(
        'required' => false,
        'config_name' => 'my_config'))

      ->add('blocLibre2',     CKEditorType::class, array(
        'required' => false,
        'config_name' => 'my_config'))

      ->add('dateCrea',      DateType::class)

      ->add('experiences', CollectionType::class, array(
        'entry_type'   => ExperiencesType::class,
        'allow_add'    => true,
        'allow_delete' => true ))

      ->add('langues', CollectionType::class, array(
        'entry_type'   => LanguesType::class,
        'allow_add'    => true,
        'allow_delete' => true))

      ->add('formations', CollectionType::class, array(
        'entry_type'   => FormationType::class,
        'allow_add'    => true,
        'allow_delete' => true))

      ->add('competences', CollectionType::class, array(
        'entry_type'   => CompetencesType::class,
        'allow_add'    => true,
        'allow_delete' => true))

      ->add('blockLang',     TextType::class, array(
     'label' => false,
     'data' => 'Langues'
))

          ->add('blockExp',     TextType::class, array(
     'label' => false,
     'data' => 'Expériences Professionnelles'
))

          ->add('blockComp',     TextType::class, array(
     'label' => false,
     'data' => 'Compétences Techniques'
))

          ->add('blockForma',     TextType::class, array(
     'label' => false,
     'data' => 'Formations'
))      

          ->add('blockLibre1',     TextType::class, array(
     'label' => false,
      'required' => false,
     'data' => 'Bloc Libre 1'
))

          ->add('blockLibre2',     TextType::class, array(
     'label' => false,
      'required' => false,
     'data' => 'Bloc Libre 2'
))

      ->add('posLang', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
            '0' => 0,'1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ), 'data' => 4,
    ))

       ->add('posComp', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
            '0' => 0, '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),'data' => 1,
    ))

       ->add('posExp', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
            '0' => 0, '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),'data' => 2,
    ))

      ->add('posForma', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),'data' => 3,
    ))

      ->add('posLibre1', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),))

      ->add('posLibre2', ChoiceType::class, array(
        'label' => false,
        'choices' => array(
           '0' => 0,  '1' => 1,'2' => 2, '3' => 3, '4' => 4,'5' => 5,'6' => 6,
        ),))

      ->add('ajouter', SubmitType::class,array('label' => 'Valider l\'ajout de ce CV'));

   
    }
    


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\CV'
        ));
    }

}
