<?php

namespace App\Form;

use App\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'alpha', 'message' => 'Le nom doit contenir uniquement des lettres.']),
                ],
            ])
            ->add('type')
            ->add('numero', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{8}$/',
                        'message' => 'Le numéro doit être composé de 8 chiffres.',
                    ]),
                ],
            ])
            ->add('idA');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}