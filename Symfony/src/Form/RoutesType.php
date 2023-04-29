<?php

namespace App\Form;

use App\Entity\Routes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoutesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('mode', ChoiceType::class, [
                'label' => 'Mode of Transportation',
                'choices' => [
                    'bus' => 'Bus',
                    'train' => 'train',
                    'tram' => 'Tram',
                    'ferry' => 'Ferry',
                    'subway' => 'Subway'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Choice(['bus', 'train', 'tram', 'ferry', 'subway'])
                ],
                'attr' => [
                    'class' => 'custom-select'
                ]
            ])
            ->add('routeduration')
            ->add('fare')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Routes::class,
        ]);
    }
}
