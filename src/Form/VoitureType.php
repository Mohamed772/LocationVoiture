<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('constructeur')
            ->add('intitule')
            ->add('moteur', ChoiceType::class, [
                'choices' => $this->getMoteurChoices()
            ])
            ->add('vitesse', ChoiceType::class, [
                'choices' => $this->getVitessChoices()
            ])
            ->add('etat', ChoiceType::class, [
        'choices' => ['Opérationnel' => 'Opérationnel', 'En-révision'=>'En-révision']
    ])
            ->add('photo')
            ->add('disponible')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }

    private function getMoteurChoices()
    {
        $choices = Voiture::MOTEUR;
        $output = [];
        foreach($choices as $c => $v){
            $output[$v] = $c;
        }
        return $output;
    }

    private function getVitessChoices()
    {
        $choices = Voiture::VITESSE;
        $output = [];
        foreach($choices as $c => $v){
            $output[$v] = $c;
        }
        return $output;
    }
}
