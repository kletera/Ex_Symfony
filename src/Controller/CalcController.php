<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalcController extends AbstractController
{
    #[Route('/calculatrice/{nb1}/{nb2}/{operateur}', name: 'app_calc')]
    public function calculatrice (int $nb1, int $nb2, string $operateur): Response
    {
        $bool=true;
        switch ($operateur) {
            case 'add':
               $resultat=$nb1+$nb2;
               $operateur="L'addition";
                break;
            case 'sous':
               $resultat=$nb1-$nb2;
               $operateur="La soustraction";
                break;
            case 'multi':
               $resultat=$nb1*$nb2;
               $operateur="La multiplication";
                break;
            case 'div':
                if($nb1==0 | $nb2==0){
                    $resultat = "On ne peut pas diviser par 0.";
                    $bool=false;
                    break;
                }
               $resultat=$nb1/$nb2;
               $operateur="La division";
                break;
            default:
                $resultat="Erreur opérateur incorrect (add,sous,multi,div).";
                $bool=false;
                break;
        }
        return $this->render('calc/index.html.twig', [
            'nbr1' => $nb1,
            'nbr2' => $nb2,
            'operateur' => $operateur,
            'resultat' => $resultat,
            'bool' => $bool
        ]);
    }
}
