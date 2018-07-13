<?php

namespace CV\ProfilBundle\Form\Profil;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfilEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->remove('dateCrea')
    ->remove('ajouter')
    ->remove('commentaires')
     ->add('modifier',      SubmitType::class,array('label' => 'Valider la modification'));
  }

  public function getParent()
  {
    return ProfilType::class;
  }
}