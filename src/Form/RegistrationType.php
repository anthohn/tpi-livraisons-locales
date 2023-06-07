<?php

namespace App\Form;

use Assert\Email;
use Assert\Lenght;
use Assert\NotBlank;
use App\Entity\TUser;
use App\Entity\TTitle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('useEmail', EmailType::class)
            ->add('useFirstName', TextType::class)
            ->add('useLastName', TextType::class)
            ->add('password', PasswordType::class)
            ->add('password_confirm', PasswordType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TUser::class,
        ]);
    }
}
