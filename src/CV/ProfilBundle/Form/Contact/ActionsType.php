<?php

namespace CV\ProfilBundle\Form\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
use CV\ProfilBundle\Form\Profil\FichierType;

class ActionsType extends AbstractType
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
    'class'        => 'CVProfilBundle:Type_action',
    'placeholder' => 'Sélection',
    'choice_label' => 'nom',
    'multiple'     => false,
    'expanded'     => false,      
  ))
      ->add('commentaires', CKEditorType::class, array(
        'label' => false,
        'config_name' => 'my_config'))
      ->add('dateAction',  DateType::class,array('required' => false,'widget' => 'single_text'))
      ->add('fichiers',     CollectionType::class, array(
        'entry_type'   => FichierType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'required' => false,
        'label' => false
      ))
      ->add('ajouter',      SubmitType::class,array('label' => 'Ajouter cette action'));
    
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\Actions'
        ));
    }

}
