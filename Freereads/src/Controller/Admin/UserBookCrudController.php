<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\ReadOnlyTrait;
use App\Entity\UserBook;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Provider\ar_EG\Text;
use PharIo\Manifest\Email;
use phpDocumentor\Reflection\Types\Integer;

class UserBookCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return UserBook::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('reader'),
            TextField::new('book'),
            TextareaField::new('comment'),
            IntegerField::new('rating'),
            TextField::new('status'),
        ];
    }
    
}
