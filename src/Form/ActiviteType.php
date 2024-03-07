<?php



namespace App\Form;

use App\Entity\activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        
                        'message' => 'Veuillez saisir un nom.'
                    ]), 
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom doit contenir uniquement des lettres.']),           
                ],  
            ])
            
            ->add('type' , ChoiceType::class, [
                'choices' => [
                    'Randonnées' => 'Randonnées',
                    'Evénements culturels' => 'Evénements culturels',
                    'Plages et sports nautiques ' => 'Plages et sports nautiques ',
                    'Croisières' => 'Croisières',

                ]])
           ->add('Date_heure',DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
                'constraints' => [
                    new GreaterThan("today")
                ]

            ))
            ->add('prix')
            ->add('image',FileType::class,[
                'label' => 'image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '9Mi',
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('description')
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}