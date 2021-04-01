<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Comment')
            ->setEntityLabelInPlural('Comment')
            ->setSearchFields(['id', 'author', 'text', 'email', 'photoFilename']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'));
    }

    public function configureFields(string $pageName): iterable
    {
        $state = TextField::new('state');
        $author = TextField::new('author');
        $text = TextareaField::new('text');
        $email = EmailField::new('email');
        $createdAt = DateTimeField::new('createdAt');
        $photoFilename = ImageField::new('photoFilename', 'Photo')->setUploadDir('public/uploads/photos');
        $conference = AssociationField::new('conference');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$author, $email, $createdAt, $state];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $state, $author, $text, $email, $createdAt, $photoFilename, $conference];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$state, $author, $text, $email, $createdAt, $photoFilename, $conference];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$state, $conference, $createdAt, $author, $email, $photoFilename, $text];
        }
    }
}
