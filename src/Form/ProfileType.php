<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom'
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom'
        ])

        ->add('save', SubmitType::class, [
            'label'=> "Editer",
            'attr' => ['class' => 'btn mt-2'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}