<?php

namespace App\Form;

use App\Entity\TTitle;
use App\Entity\TAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addFirstName', TextType::class)
            ->add('addLastName', TextType::class)
            ->add('addAddress', TextType::class)
            ->add('addCity', TextType::class)
            ->add('addPc', NumberType::class)
            ->add('idxTitle', EntityType::class, [
                'class' => TTitle::class,
                'choice_label' => 'titName'
                ])
            ->add('addCountry', HiddenType::class)
            ->add('addLatitude', HiddenType::class)
            ->add('addLongitude', HiddenType::class)
            ->add('idxUser', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TAddress::class,
        ]);
    }
}
