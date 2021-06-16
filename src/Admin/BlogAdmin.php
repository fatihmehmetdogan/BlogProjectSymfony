<?php

namespace App\Admin;

use App\Entity\Blog;
use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

final class BlogAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content')
                    ->add('title', TextType::class, array('data_class' => null))
                   ->add('content', TextareaType::class, array('data_class' => null))
                   ->add('image', FileType::class, array('data_class' => null))
                   ->add('status')
            ->end()
            ->with('Meta data')
                ->add('categories', EntityType::class, [
                     'class' => Category::class,
                     'multiple' => 'true',
                     'choice_label' => 'name',
            ])
            ->end();
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
                    ->addIdentifier('content')
                    ->add('status');
    }
    /**
     * @param Blog $object
     */
    public function prePersist($object)
    {
        $uploadedImageFile = $this->getForm()->get('image')->getData();
        $imageFilename="";
        if($uploadedImageFile){
            $extensions = $uploadedImageFile->guessExtension();
            $imageFilename = time().".". $extensions;
            $object->setImage($imageFilename);
        }
        try {
            $uploadedImageFile->move(
                 "uploads/",
                $imageFilename
            );
        }catch (FileException $e){
        }
        $object->setImage($imageFilename);
    }
}
