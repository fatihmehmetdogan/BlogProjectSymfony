<?php



namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper->add('name', TextType::class)
            ->add('content', TextType::class)
                ->add('is_confirmed', CheckboxType::class, [
                    "required" => false
                ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper->addIdentifier('name')
            ->add('content', TextType::class)
            ->add("is_confirmed", CheckboxType::class);

    }
}

