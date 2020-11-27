<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Entity\Quack;
use App\Entity\Tag;
use App\Form\Quack1Type;
use App\Form\Quack2Type;
use App\Repository\QuackRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{
    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {

        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findBy(['parent'=>null]),

        ]);
    }

    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {

        $quack = new Quack();

        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploaded_data=$form->all()['uploaded']->getData();
            $originalFilename = pathinfo($uploaded_data->getClientOriginalName(), PATHINFO_FILENAME); //activate extension=fileinfo in php.ini
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploaded_data->guessExtension();
            try {
                $uploaded_data->move(
                    $this->getParameter('upload_dir'),
                    $newFilename
                );
            } catch (FileException $e) {
                dd("DONT MOVE !");
            }

            $date =new DateTime("now", new \DateTimeZone('Europe/Paris'));
            $quack->setCreatedAt($date);

            $quack->setAuthor($this->getUser());

//            $path_upload_dir = $this->getParameter('upload_dir');
//            $path_upload_dir = substr($path_upload_dir, strpos($path_upload_dir, "quacknet"));
            $quack->setPicture($newFilename);
//            $dataTag = $form->all()['tags']->getData()[0];

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET","POST"})
     */
    public function show(Request $request, Quack $quack): Response
    {
        $comment= new Quack();
        $formcritik = $this->createForm(Quack2Type::class, $comment);
        $formcritik->handleRequest($request);
        $comment->setParent($quack);
        $date =new DateTime("now", new \DateTimeZone('Europe/Paris'));
        $comment->setCreatedAt($date);
        $comment->setAuthor($this->getUser());
        $ducky= $quack->getAuthor()->getDuckname();

        if ($formcritik->isSubmitted() && $formcritik->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/show.html.twig', [
            'formcritik' => $formcritik->createView(),
            'quack' => $quack,
            'duck' =>$ducky,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack): Response
    {
        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        $filesystem = new Filesystem();
        if ($this->isCsrfTokenValid('delete'.$quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $filesystem->remove($quack->getPicture());
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }
}
