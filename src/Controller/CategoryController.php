<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CategoryService;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController{
    public function __construct(private CategoryService $categoryService)
    {}

    #[Route(path:'/categories', name: 'app_categories')]
    #[IsGranted('IS_AUTHENTICATED_FULLY', message:'Vous n\'est pas autorisé')]
    public function showAllCategories(): Response
    {
        //Récupération de toutes les catégories de la BDD
        $categories = $this->categoryService->getCategories();

        return $this->render('category/show_all_categories.html.twig',[
            'categories' => $categories
        ]);
    }

    #[Route('/category/{id}', name:'app_category', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function showCategoryById(int $id): Response
    {
        return $this->render('category/show_category_id.html.twig', [
            "category" => $this->categoryService->getCategoryById($id)
        ]);
    }

    #[Route(path:'/category/new', name:'app_category_new', methods:["GET", "POST"])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function new(Request $request):Response 
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            //ajouter avec le CategoryService::saevCategory
            $msg = $this->categoryService->saveCategory($category);

            $this->addFlash('notice', $msg);

            return $this->redirectToRoute('app_category_new');
        }

        return $this->render('category/category_new.html.twig', [
            'form'=> $form
        ]);
    }

    #[Route('/category/{id}/edit', name:'app_category_edit', requirements: ['id' => '\d+'], methods:["GET", "POST"])]
    #[IsGranted('ROLE_USER', message:'Vous n\'est pas autorisé')]
    public function editCategorieById(int $id, Request $request): Response{

        $category=$this->categoryService->getCategoryById($id);
        if($category === null){
            throw $this->createNotFoundException('Erreur 404 : Categorie introuvable.');
        }

        $form = $this->createForm(CategoryType::class, $category, [
            'label_save_edit'=>'Modifier'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $msg = $this->categoryService->saveCategory($category);

            $this->addFlash('notice', $msg);

            return $this->redirectToRoute('app_category_edit',[ 'id'=>$id]);
        }

        return $this->render('category/category_edit.html.twig', [
            'form'=> $form
        ]);
    }
    
}