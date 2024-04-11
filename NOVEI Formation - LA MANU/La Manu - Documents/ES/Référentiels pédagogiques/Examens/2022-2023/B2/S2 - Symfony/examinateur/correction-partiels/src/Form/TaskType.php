<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Category;
use App\Entity\TaskStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Intitulé',
            ])
            ->add('description')
            ->add('closingDate', DateType::class, [
                'label' => "Date d'écheance",
                'widget' => 'choice',
                'input' => 'datetime_immutable'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Categorie'
            ])
            ->add('status', EntityType::class, [
                'class' => TaskStatus::class,
                'choice_label' => 'name',
                'label' => 'Status'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}