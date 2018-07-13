<?php

namespace CV\ProfilBundle\Form\Profil;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('dateCrea',  DateType::class, array(
     'widget' => 'single_text'))
      ->add('civilite',   ChoiceType::class,  array(
        'placeholder' => 'Sélection',
    'choices'  => array(
        'Monsieur' => 'M.',
        'Madame' => 'Mme',
    ),))
      ->add('nom',     TextType::class)
      ->add('prenom',    TextType::class)
      ->add('intitule',    TextType::class)
     ->add('statut', EntityType::class, array(
    'class'        => 'CVProfilBundle:Statut',
    'placeholder' => 'Sélection',
    'choice_label' => 'nom',
    'multiple'     => false,
    'expanded'     => false,      
  ))
      ->add('domaines', EntityType::class, array(
    'class'        => 'CVProfilBundle:Domaines',
    'choice_label' => 'nom',
    'multiple'     => true,
    'expanded'     => true,
          'attr' => array(
            'class' => 'form-inline'
        ),
  ))

      ->add('adresse',     TextType::class,array('required' => false))
      ->add('ville',     TextType::class,array('required' => false))
      ->add('code_postal',     TextType::class)
      ->add('telephone',     TextType::class)
      ->add('mail',     EmailType::class)
      ->add('fichiers',     CollectionType::class, array(
        'entry_type'   => FichierType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'required' => false,
        'label' => false
      ))
      ->add('urls', CollectionType::class, array(
        'entry_type'   => UrlsType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'required' => false,
        'label' => false
      ))
      ->add('commentaires', CollectionType::class, array(
            'entry_type' => CommentaireFormType::class,
            'required' => false,
        'allow_add'    => true,
        'allow_delete' => true ))
      ->add('ajouter', SubmitType::class,array('label' => 'Ajouter ce profil'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\Profil'
        ));
    }

}
