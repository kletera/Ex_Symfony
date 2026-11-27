<?php

namespace App\Tests\Unit\Service;

use App\Entity\Category;
use App\Service\CategoryService;
use App\Repository\CategoryRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class CategoryServiceTest extends TestCase{
    // Methode
    public function testGetCategoriesReturnsAllCategories():void{
        // Arrange
        $cat1 = (new Category())->setName('Shonen');
        $cat2 = (new Category())->setName('Shojo');
        $catego=[$cat1,$cat2];

        $repository=$this->createStub(CategoryRepository::class);
        $repository->methode('findAll')->willReturn($catego);
        $em= $this->createStub(EntityManagerInterface::class);
        $service=new CategoryService($repository,$em);

        // Act
        $actual=$service->getCategories();
        
        // Assert
        self::assertSame($catego, $actual);
    }
}