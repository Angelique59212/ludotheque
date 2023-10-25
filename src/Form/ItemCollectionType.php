<?php

namespace App\Form;

use App\Entity\ItemsCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('editor')
            ->add('number_player')
            ->add('playing_time')
            ->add('language')
            ->add('category')
            ->add('library')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemsCollection::class,
        ]);
    }
}
