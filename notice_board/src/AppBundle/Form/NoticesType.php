<?php

namespace AppBundle\Form;

use AppBundle\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NoticesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Wybierz kategorię'
            ])
            ->add('title', TextType::class, [
                'label' => 'Tytuł'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis'
            ])
            ->add('date', DateTimeType::class, [
                "widget" => 'single_text',
                "format" => 'dd-MM-yyyy',
                "data" => new \DateTime("30 days"),
                'label' => 'Data wygaśnięcia'
            ])
            ->add('imageName', FileType::class, [
                'mapped' => false,
                'label' => 'Dodaj zdjęcie'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Notices'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_notices';
    }
}
