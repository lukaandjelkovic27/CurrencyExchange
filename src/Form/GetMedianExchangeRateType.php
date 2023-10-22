<?php

namespace App\Form;

use App\Validator\Constraints\DateRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetMedianExchangeRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('start_date', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type("DateTime"),
            ],
        ])

        ->add('end_date', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type("DateTime"),
                new DateRange(),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
