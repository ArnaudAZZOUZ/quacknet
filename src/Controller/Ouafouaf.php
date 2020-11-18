<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Ouafouaf extends AbstractController
{
    /**
     * @Route("/chien", name="chien")
     */
    public function post():Response{
        $publication="ouafouafouaf";
        return $this->render('chien/chien.html.twig', [
            'post' => $publication,
        ]);
    }


}