<?php

namespace App\Controller\Admin;

use App\Entity\TUser;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TUser::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPaginatorPageSize(20);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('email', 'adresse e-mail')
                ->setFormTypeOption('disabled', 'disabeled'),
            TextField::new('useFirstName', 'Prénom'),
            TextField::new('useLastName', 'Nom'),
            TextField::new('useNumberPhone', 'Numéro de téléphone'),
            DateTimeField::new('useCreatedDate', 'Date de création du compte')
                ->setFormTypeOption('disabled', 'disabeled'),
            ArrayField::new('roles')
                ->hideOnIndex()            
        ];
    }
}
