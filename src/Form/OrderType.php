<?php

namespace App\Form;

use App\Entity\TTime;
use App\Entity\TOrder;
use App\Entity\TAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('idxAddress', EntityType::class, [
            'class' => TAddress::class,
            'choice_label' => 'addAddress',
            'label' => false 
            ])
        ->add('idxTime', EntityType::class, [
            'class' => TTime::class,
            'choice_label' => 'timSlice',
            'label' => false 
            ])
        ->add('ordDate', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],

        ])
        // ->add('ordPrice')
        // ->add('idxStatus')
        // ->add('idxUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TOrder::class,
        ]);
    }
}
