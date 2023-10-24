<?php

namespace App\Controller;

use App\Entity\Library;
use App\Form\LibraryType;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index( LibraryRepository $libraryRepository): Response
    {
        return $this->render('library/index.html.twig', [
            'libraries'=> $libraryRepository->findAll(),
        ]);
    }

    #[Route('library/add', name: 'add_library')]
    public function addLibrary(Request $request, EntityManagerInterface $em): Response
    {
        $library = new Library();
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($library);
            $em->flush();
            return $this->redirectToRoute('add_library');
        }
        return $this->render('library/add.html.twig', [
            'form_add_library' =>$form->createView(),
        ]);
    }
}
