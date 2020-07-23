<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'w-100', 'placeholder' => 'Topic\'s name'],
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'w-100', 'placeholder' => 'Your message'],
                'mapped' => false,
            ])
            ->add('section', EntityType::class, [
                'attr' => ['class' => 'mb-4'],
                'class' => Section::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
            'attr' => ['id' => 'form_new_topic']
        ]);
    }
}
