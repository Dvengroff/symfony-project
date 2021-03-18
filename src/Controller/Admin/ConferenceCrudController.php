<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference')
            ->setEntityLabelInPlural('Conference')
            ->setSearchFields(['id', 'city', 'year']);
    }

    public function configureFields(string $pageName): iterable
    {
        $city = TextField::new('city');
        $year = TextField::new('year');
        $isInternational = Field::new('isInternational');
        $comments = AssociationField::new('comments');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $city, $year, $isInternational, $comments];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $city, $year, $isInternational, $comments];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$city, $year, $isInternational, $comments];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$city, $year, $isInternational, $comments];
        }
    }
}
