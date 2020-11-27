<?php

namespace App\Controller;

use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/quack", methods={"GET"})
     */
    public function getQuacks(QuackRepository $quackRepository): Response
    {

        return $this->json( $quackRepository->findBy(['parent'=>null]), 200,[], ['groups' => 'getQuacks']);


//        return $this->render('quack/index.html.twig', [
//            'controller_name' => 'ApiController',
//        ]);
    }
}
