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
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class RoutesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Route Name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255])
                ]
            ])
            ->add('mode', ChoiceType::class, [
                'label' => 'Mode of Transportation',
                'choices' => [
                    'bus' => 'Bus',
                    'train' => 'Train',
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
            ->add('routeDuration', null, [
                'label' => 'Route Duration (minutes)',
                'constraints' => [
                    new NotBlank(),
                    new PositiveOrZero()
                ]
            ])
            ->add('fare', null, [
                'label' => 'Fare (USD)',
                'constraints' => [
                    new NotBlank(),
                    new PositiveOrZero()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Routes::class,
        ]);
    }
}
