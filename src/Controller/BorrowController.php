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

#[Route('/borrow')]
class BorrowController extends AbstractController
{
    #[Route('/', name: 'app_borrow_index', methods: ['GET'])]
    public function index(BorrowRepository $borrowRepository): Response
    {
        return $this->render('borrow/index.html.twig', [
            'borrows' => $borrowRepository->findBy(['user'=>$this->getUser()->getId()]),
        ]);
    }

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

            return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrow/new.html.twig', [
            'borrow' => $borrow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrow_show', methods: ['GET'])]
    public function show(Borrow $borrow): Response
    {
        return $this->render('borrow/show.html.twig', [
            'borrow' => $borrow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrow $borrow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowType::class, $borrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrow/edit.html.twig', [
            'borrow' => $borrow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrow_delete', methods: ['POST'])]
    public function delete(Request $request, Borrow $borrow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrow->getId(), $request->request->get('_token'))) {
            $entityManager->remove($borrow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
    }

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
