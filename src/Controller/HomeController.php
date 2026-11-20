<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $formations = [
        [
            'title' => 'Développement PHP',
            'description' => 'Découvrir le développement côté serveur.',
        ],
        [
            'title' => 'Symfony',
            'description' => 'Structurer une application web en PHP.',
        ],
        [
            'title' => 'Vue',
            'description' => 'Créer des interfaces web dynamiques avec Vue.js.',
        ],
        [
            'title' => 'Design',
            'description' => 'Concevoir des interfaces claires et esthétiques.',
        ],
        [
            'title' => 'Pub',
            'description' => 'Découvrer la joie de la boisson.',
        ],
    ];
        return $this->render('home/index.html.twig',[
             "messages" => [
                "Bienvenue sur le site !",
                "Enregistrement réussi.",
                "Une erreur est survenue."
            ],
            "types" => [
                "",
                "success",
                "danger"
            ],
            'formation' => $formations,
        ]);
    }
}

