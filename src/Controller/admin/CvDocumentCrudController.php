<?php

namespace App\Controller\admin;

use App\Entity\CvDocument;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CvDocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CvDocument::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field::new('uploadedFile', 'Fichier CV (PDF)')
            ->setFormType(FileType::class)
            ->setFormTypeOptions([
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '4M',
                        mimeTypes: ['application/pdf'],
                        mimeTypesMessage: 'Merci d\'envoyer un fichier PDF.'
                    ),
                ],
            ])
            ->onlyOnForms();

        yield TextField::new('filename', 'Nom du fichier')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Mis à jour le')->onlyOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handleUpload($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handleUpload($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleUpload(CvDocument $cv): void
    {
        $file = $cv->getUploadedFile();

        if ($file === null) {
            return;
        }

        $cv->setContent(file_get_contents($file->getPathname()));
        $cv->setFilename($file->getClientOriginalName());
        $cv->setUpdatedAt(new \DateTime());
    }
}
