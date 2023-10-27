<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Form\BorrowType;
use App\Repository\BorrowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
#[Route('/borrow')]
class BorrowController extends AbstractController
{
    /*
     *function to have all the borrowing
     *The BorrowRepository  used to retrieve user-related borrows
     *I put a findBy and not a findAll to retrieve only those of the current user
     */
    #[Route('/', name: 'app_borrow_index', methods: ['GET'])]
    public function index(BorrowRepository $borrowRepository): Response
    {
        return $this->render('borrow/index.html.twig', [
            'borrows' => $borrowRepository->findBy(['user'=>$this->getUser()->getId()]),
        ]);
    }

    /*
     *function to add a borrow
     *request to retrieve the data submitted by the form
     *the EntityManager to be able to persist the data
     *create new instance borrow
     *the response will return the form creation page
     */
    #[Route('/new', name: 'app_borrow_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $borrow = new Borrow();
        $form = $this->createForm(BorrowType::class, $borrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $borrow->setUser($this->getUser());
            $entityManager->persist($borrow);
            $entityManager->flush();

            $this->addFlash('success', "Ajout d'emprunt effectué avec succès");
            return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrow/new.html.twig', [
            'borrow' => $borrow,
            'form' => $form,
        ]);
    }

    /*
     *function for display borrow
     */
    #[Route('/{id}', name: 'app_borrow_show', methods: ['GET'])]
    public function show(Borrow $borrow): Response
    {
        return $this->render('borrow/show.html.twig', [
            'borrow' => $borrow,
        ]);
    }

   /*
    *update Borrow
    * recover the request, recover the borrow, and the manager to be able to send to the database
    */
    #[Route('/{id}/edit', name: 'app_borrow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrow $borrow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowType::class, $borrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', "Modification effectué avec succès");

            return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrow/edit.html.twig', [
            'borrow' => $borrow,
            'form' => $form,
        ]);
    }

    /*
     * remove the borrow and redirect after deletion to index page
     * call the instance of the borrow to delete
     */
    #[Route('/{id}', name: 'app_borrow_delete', methods: ['POST'])]
    public function delete(Request $request, Borrow $borrow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrow->getId(), $request->request->get('_token'))) {
            $entityManager->remove($borrow);
            $entityManager->flush();
        }

        $this->addFlash('success', "Suppression effectué avec succès");

        return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
    }

    /*
     *function for unfinished loans
     *retrieve the parameter value of the current query
     *call the repository function for dates. Using getUser to get the one that concerns the current user
     */
    #[Route('/search/borrow', name: 'app_search_borrow', methods: ['GET', 'POST'])]
    public function search(Request $request, BorrowRepository $borrowRepository): Response
    {

        if ($request->isMethod('GET')) {
            $startDate = $request->query->get('date_start');
            $endDate = $request->query->get('date_end');

            if ($startDate && $endDate) {
                $borrows = $borrowRepository->findBorrowNoFinished($startDate, $endDate, $this->getUser()->getId());
            } else {
                $borrows = [];
            }
        }
        return $this->render('borrow/search.html.twig', [
            'borrows'=>$borrows
        ]);
    }
}
