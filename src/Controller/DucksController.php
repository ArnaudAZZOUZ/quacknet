<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Entity\Quack;
use App\Form\DuckType;
use App\Form\Quack1Type;
use App\Repository\DucksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/ducks")
 */
class DucksController extends AbstractController
{
    /**
     * @Route("/", name="ducks_index", methods={"GET"})
     */
    public function index(DucksRepository $ducksRepository): Response
    {
        return $this->render('ducks/index.html.twig', [
            'ducks' => $ducksRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="duck_show", methods={"GET"})
     */
    public function show(Duck $duck): Response
    {
        return $this->render('ducks/show.html.twig', [
            'duck' => $duck,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="duck_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duck $duck, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duck->setPassword($passwordEncoder->encodePassword($duck, $duck->getPassword()
                        ));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ducks_index');
        }

        return $this->render('ducks/edit.html.twig', [
            'duck' => $duck,
            'duck_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duck_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Duck $duck): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duck->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duck);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ducks_index');
    }

}
