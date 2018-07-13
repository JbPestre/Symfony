<?php

namespace CV\ProfilBundle\Form\Contact;

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

class ContactType extends AbstractType
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
      ->add('prenom',     TextType::class)
      ->add('poste',     TextType::class)
      ->add('domaines', EntityType::class, array(
    'class'        => 'CVProfilBundle:Domaines',
    'choice_label' => 'nom',
    'multiple'     => true,
    'expanded'     => true,
      'attr' => array(
            'class' => 'form-inline'
        ),
  ))
      ->add('tel1',     TextType::class,array('required' => false))
      ->add('tel2',     TextType::class,array('required' => false))
      ->add('tel3',     TextType::class,array('required' => false))
      ->add('email',     TextType::class)
      ->add('ajouter',      SubmitType::class,array('label' => 'Ajouter ce contact'));
    
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CV\ProfilBundle\Entity\Interlocuteur'
        ));
    }

}
