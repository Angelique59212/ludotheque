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
    /*
    *function to have all the items
    *The ItemRepository  used to retrieve user-related borrows
    *I put a findBy and not a findAll to retrieve only those of the current user
    */
    #[Route('item/collection', name: 'app_items', methods: ['GET'])]
    public function index(ItemsCollectionRepository $itemsCollectionRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items' => $itemsCollectionRepository->findBy(['user'=>$this->getUser()->getId()]),
        ]);
    }

    /*
    *function to add item
    *request to retrieve the data submitted by the form
    * the EntityManager to be able to persist the data
    * the response will return the form creation page
    */
    #[Route('item/addItem', name: 'add_item', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }
        $item = new ItemsCollection();
        $form = $this->createForm(ItemsCollectionType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setUser($this->getUser());
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/addItem.html.twig', [
            'form_add_item'=>$form->createView(),
        ]);
    }

//    #[Route('/{id}', name: 'show_items', methods: ['GET'])]
//    public function show(ItemsCollection $itemsCollection): Response
//    {
//        return $this->render('item/show.html.twig', [
//            'items_collection' => $itemsCollection,
//        ]);
//    }

        /*
        *update item
        * recover the request, recover the item, and the manager to be able to send to the database
        */
    #[Route('/{id}/edit', name: 'edit_item', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemsCollection $itemsCollection, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ItemsCollectionType::class, $itemsCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_items', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/edit.html.twig', [
            'items_collection' => $itemsCollection,
            'form' => $form,
        ]);
    }

    /*
     * remove the item and redirect after deletion to index page
     * call the instance of the item to delete
     * execute if token valid
     */
    #[Route('/{id}', name: 'app_items_collection_delete', methods: ['POST'])]
    public function delete(Request $request, ItemsCollection $itemsCollection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemsCollection->getId(), $request->request->get('_token'))) {
            $entityManager->remove($itemsCollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_library', [], Response::HTTP_SEE_OTHER);
    }

    /*
     * function search by keyWord
     * request to retrieve the data submitted
     * if the parameter is found then it executes the function and returns the view otherwise it returns an empty array
     */
 #[Route('/search', name: 'app_items_search', methods: ['GET'])]
    public function search(Request $request, ItemsCollectionRepository $itemsCollectionRepository):Response
    {
        $param = $request->get('wordKey');
        if ($param) {
            $item = $itemsCollectionRepository->searchByWord($param, $this->getUser()->getId());
        }else {
            $item = [];
        }
        return $this->render('item/search.html.twig', [
            'results'=>$item,
        ]);
    }

    /*
    * function search by editor
    * request to retrieve the data submitted
    * if the parameter is found then it executes the function and returns the view otherwise it returns an empty array
    */
    #[Route('/searchByEditor', name: 'app_items_search_editor', methods: ['GET'])]
    public function searchByEditor(Request $request, ItemsCollectionRepository $itemsCollectionRepository):Response
    {
        $param = $request->get('wordKey');
        if ($param) {
            $item = $itemsCollectionRepository->searchByEditor($param, $this->getUser()->getId());
        }else {
            $item = [];
        }
        return $this->render('item/searchByEditor.html.twig', [
            'results'=>$item,
        ]);
    }

}
