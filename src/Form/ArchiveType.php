<?php

namespace App\Form;

use App\Entity\Archive;
use App\Entity\Category;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Code_archive', TextType::class)
            ->add('intitule_archive', TextType::class)
            ->add('date_creation')
            ->add('date_archivage')
            //->add('parent')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre',
                'label' => 'Category'
            ])

            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'titre',
                'label' => 'Service'
            ])
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Archive::class,
        ]);
    }
}
