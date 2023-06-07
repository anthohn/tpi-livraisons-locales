<?php

namespace App\Form;

use App\Entity\TTime;
use App\Entity\TOrder;
use App\Entity\TAddress;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idxAddress', EntityType::class, [
                'class' => TAddress::class,
                'choice_label' => 'addAddress'
                ])
            ->add('idxTime', EntityType::class, [
                'class' => TTime::class,
                'choice_label' => 'timSlice'
                ])
            ->add('ordDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThan([
                        'value' => 'today',
                        'message' => 'La date doit être supérieure à aujourd\'hui.',
                    ]),
                ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TOrder::class,
        ]);
    }
}
