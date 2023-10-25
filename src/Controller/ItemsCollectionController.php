<?php

namespace App\Controller;

use App\Entity\ItemsCollection;
use App\Form\ItemsCollectionType;
use App\Repository\ItemsCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('items/collection')]
class ItemsCollectionController extends AbstractController
{
    #[Route('/item/collection', name: 'app_items', methods: ['GET'])]
    public function index(ItemsCollectionRepository $itemsCollectionRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items' => $itemsCollectionRepository->findBy(['user'=>$this->getUser()->getId()]),
        ]);
    }

    #[Route('item/addItem', name: 'add_item', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $item = new ItemsCollection();
        $form = $this->createForm(ItemsCollectionType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/addItem.html.twig', [
            'form_add_item'=>$form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show_items', methods: ['GET'])]
    public function show(ItemsCollection $itemsCollection): Response
    {
        return $this->render('items_collection/show.html.twig', [
            'items_collection' => $itemsCollection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_collection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemsCollection $itemsCollection, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ItemsCollectionType::class, $itemsCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_items_collection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('items_collection/edit.html.twig', [
            'items_collection' => $itemsCollection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_items_collection_delete', methods: ['POST'])]
    public function delete(Request $request, ItemsCollection $itemsCollection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemsCollection->getId(), $request->request->get('_token'))) {
            $entityManager->remove($itemsCollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_items_collection_index', [], Response::HTTP_SEE_OTHER);
    }
}
