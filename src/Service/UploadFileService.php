<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileService
{
    public function __construct(
        private readonly string $targetDirectory,
        private readonly SluggerInterface $slugger,
        
    ) {}
    
    public function upload(UploadedFile $file):string{

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        
        $safeName  = $this->slugger->slug($originalFilename);
        $newFilename = $safeName .'-'. uniqid().'.'.$file->guessExtension();

        try {
            //Déplacer dans le dossier public/images
            $file->move($this->targetDirectory,  $newFilename);
        } catch (FileException $e) {
            return 'Erreur de copie du fichier';
        }
        return $newFilename;
    }

}
