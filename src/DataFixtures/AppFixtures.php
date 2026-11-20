<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Book;
use DateTimeImmutable;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création d'un objet Faker
        $faker = Faker\Factory::create('fr_FR');

        $tabCatego=[];

        for($i=0; $i<20; $i++){
            //Créer des objets Category
            $category = new Category();
            $category->setName($faker->unique->word());
            
            //persister l'objet
            $manager->persist($category);
            $tabCatego[]=$category;
        }
        
        for($i=0; $i<60; $i++){
            //Créer des objets Book
            $book = new Book();
            $book->setTitle($faker->sentence(3));
            $book->setResume($faker->paragraph(2));
            $book->setPublishAt(new DateTimeImmutable($faker->date()));
            $book->setAuthor($faker->name());
            for ($j=0; $j < 5; $j++) { 
                $book->addCategory($faker->randomElement($tabCatego)) ;               
            }
            
            //persister l'objet
            $manager->persist($book);
        }

        $manager->flush();
    }
}
