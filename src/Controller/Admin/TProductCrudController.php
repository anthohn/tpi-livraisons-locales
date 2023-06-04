<?php

namespace App\Controller\Admin;

use App\Entity\TProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Produits')
            ->setEntityLabelInSingular('Produit')
            ->setPaginatorPageSize(20);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('proName', 'Nom'),
            NumberField::new('proPrice', 'Prix'),
            NumberField::new('proQuantity', 'Quantité en stock'),
            BooleanField::new('proIsActive', 'En ligne'),
            TextField::new('proDescription', 'Description'),
            ImageField::new('proImageName','Image')
                ->setUploadDir('/public/images/product')
                ->hideOnIndex()
        ];
    }
    
}
