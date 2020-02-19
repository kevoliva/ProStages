<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\EntrepriseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;


class StageType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('titre')
    ->add('description')
    ->add('entreprise', EntrepriseType::class)
    ->add('formation', EntityType::class, [
      'class' => Formation::class,
      'choice_label' => function(Formation $formation){
        return $formation->getNomCourt().' - '.$formation->getNom();
      },
      'multiple' => true,
      'expanded' => true
    ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Stage::class,
    ]);
  }
}
