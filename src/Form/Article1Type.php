<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class Article1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',
                TextareaType::class,
                [
                    'label' => 'Titre',
                    'attr' => [
                        'placeholder' => 'Titre',
                        'class' => 'tinymce'
                    ]
                ])
            ->add('contenu',
            TextareaType::class,
            [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => 'Contenu',
                    'class' => 'tinymce'
                ]
            ])
            ->add('date', DateType::class, [
                    // renders it as a single text box
                    'widget' => 'single_text',
                ]
    )
            ->add('imageUrl')
            ->add('utilisateur')
            ->add('MaCategorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
