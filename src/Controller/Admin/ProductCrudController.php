<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Utils\AwsUtils;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductCrudController extends AbstractCrudController
{
    public function __construct(private AwsUtils $awsUtils)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield TextField::new('details');
        yield ImageField::new('image')
                ->setUploadDir('public/uploads')
                ->setBasePath($_ENV['AWS_PATH'])
                ->setUploadedFileNamePattern('product-[timestamp].[extension]')
                ->setFormTypeOption('upload_new', function (UploadedFile $file, string $uploadDir, string $fileName) {
                    $this->awsUtils->uploadFile($file, $fileName);
                });
    }
}
