<?php

namespace CV\ProfilBundle\Form\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use CV\ProfilBundle\Form\Profil\FichierType;
use CV\ProfilBundle\Form\Profil\CommentaireFormType;
use CV\ProfilBundle\Form\Profil\UrlsType;


class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('dateCrea',  DateType::class, array(
     'widget' => 'single_text'))
      ->add('nom',     TextType::class)
     ->add('type', EntityType::class, array(
    'class'        => 'CVProfilBundle:Type_client',
    'placeholder' => 'Sélection',
    'choice_label' => 'nom',
    'multiple'     => false,
    'expanded'     => false,      
  ))
     ->add('pays', EntityType::class, array(
    'class'        => 'CVProfilBundle:Pays',
    'placeholder' => 'Sélection',
    'choice_label' => 'nom',
    'multiple'     => false,
    'expanded'     => false,      
  ))

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
      ->add('ajouter',      SubmitType::class,array('label' => 'Ajouter ce client'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\Client'
        ));
    }

}
