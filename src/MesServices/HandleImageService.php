<?php 

namespace App\MesServices;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class HandleImageService
{
    private $slugger;

    private $containerBag;

    public function __construct(SluggerInterface $slugger,ContainerBagInterface $containerBag)
    {
        $this->slugger = $slugger;
        $this->containerBag = $containerBag;
    }

    public function save(UploadedFile $file,object $entity)
    {
        //Je vais d'abord récupérer le nom : 
        $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);

        //Je dois sluggifier le nom pour le rendre safe :
        $safeFileName = $this->slugger->slug($originalFilename);

        //Je dois changer le nom pour le rendre unique
        $uniqFilename = $safeFileName . '-' .  md5(uniqid()) . '.' . $file->guessExtension();

        //Je prend le file et je l envoie dans sa maison(/public/uploads/images)
        $file->move(
            $this->containerBag->get('app_images_directory'),
            $uniqFilename
        );

        //J'enregistre le chemin qui me ramene vers ce fichier en bdd
        //Je set le ImagePath (propriété de catégorie)
        $entity->setImagePath('/uploads/images/' . $uniqFilename);
    }

    public function edit(UploadedFile $file,object $entity,string $originalImagePath)
    {
         $this->save($file,$entity);

         //Supprimer l ancienne image
         $fileOldImage = $this->containerBag->get('app_images_directory') . '/../..' . $originalImagePath;
         
         if(file_exists($fileOldImage))
         {
             unlink($fileOldImage);
         }
    }
}