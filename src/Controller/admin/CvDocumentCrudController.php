<?php

namespace App\Controller\admin;

use App\Entity\CvDocument;
use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CvDocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CvDocument::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FileField::new('file')
            ->setLabel('Fichier CV (PDF)')
            ->setBasePath('files')
            ->setUploadDir('public/files')
            ->setUploadedFileNamePattern('cv.[extension]');
    }
}
