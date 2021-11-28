<?php

namespace App\Controller\Admin;

use App\Entity\Archive;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Repository\ArchiveRepository;

class ArchiveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Archive::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('Code_archive'),
            TextField::new('intitule_archive'),
            DateField::new('date_creation'),
            DateField::new('date_archivage'),
            AssociationField::new('service'),
            AssociationField::new('category')
        ];
    }
}
