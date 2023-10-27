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

#[Route('/library')]
class LibraryController extends AbstractController
{
    /*
     *function to have all the libraries
     *The libraryRepository used to retrieve user-related libraries
     *I put a findBy and not a findAll to retrieve only those of the current user
     */
    #[Route('/', name: 'app_library', methods: ['GET'])]
    public function index(LibraryRepository $libraryRepository): Response
    {
        return $this->render('library/index.html.twig', [
            'libraries' => $libraryRepository->findBy(['user'=>$this->getUser()->getId()]),
        ]);
    }

    /*
     *function to add a library
     *request to retrieve the data submitted by the form
     * the EntityManager to be able to persist the data
     * create new instance library
     * the response will return the form creation page
     */
    #[Route('/add', name: 'add_library', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $library = new Library();
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $library->setName(strtoupper($library->getName()));
            $library->setUser($this->getUser());
            $em->persist($library);
            $em->flush();

            $this->addFlash('success', "Ajout effectué avec succès");
            return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('library/add.html.twig', [
            'form_add_library'=>$form->createView(),
        ]);
    }

    /*
     *function for display library
     */
    #[Route('/{id}', name: 'show_library', methods: ['GET'])]
    public function show(Library $library): Response
    {
        return $this->render('library/show.html.twig', [
            'library' => $library,
        ]);
    }

    /*
    *update library
    * recover the request, recover the library, and the manager to be able to send to the database
    */
    #[Route('/{id}/edit', name: 'edit_library', methods: ['GET', 'POST'])]
    public function edit(Request $request, Library $library, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $library->setName(strtoupper($library->getName()));
            $entityManager->flush();

            $this->addFlash('success', "Modification effectué avec succès");
            return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('library/edit.html.twig', [
            'library' => $library,
            'form' => $form,
        ]);
    }

    /*
    * remove the library and redirect after deletion to index page
    * call the instance of the library to delete
    */
    #[Route('/{id}', name: 'delete_library', methods: ['POST'])]
    public function delete(Request $request, Library $library, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$library->getId(), $request->request->get('_token'))) {
            $entityManager->remove($library);
            $entityManager->flush();
        }
        $this->addFlash('success', "Suppression effectué avec succès");
        return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
    }
}
