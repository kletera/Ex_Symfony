<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CategoryService;

class CategoryController extends AbstractController{
    public function __construct(private CategoryService $categoryService)
    {}

    #[Route('/categories', name: 'app_categories')]
    public function showAllCategories():Response{
        $categories = $this->categoryService->getCategories();
    
        return $this->render('categoy/show_all_categories.html.twig', [
            'categories' =>  $categories,
        ]);
    }
}