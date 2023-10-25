<?php

namespace App\Controller;

use App\Entity\ItemsCollection;
use App\Form\ItemCollectionType;
use App\Repository\ItemsCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemCollectionController extends AbstractController
{
    #[Route('/item/collection', name: 'app_items')]
    public function index(ItemsCollectionRepository $itemsCollectionRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items'=> $itemsCollectionRepository->findAll(),
        ]);
    }

    #[Route('item/addItem', name: 'add_item')]
    public function addItemsCollection(Request $request, EntityManagerInterface $em): Response
    {
        $item = new ItemsCollection();
        $form = $this->createForm(ItemCollectionType::class, $item);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($item);
            $em->flush();
            return $this->redirectToRoute('app_library');
        }
        return $this->render('item/addItem.html.twig', [
            'form_add_item'=>$form->createView(),
        ]);
    }
}
