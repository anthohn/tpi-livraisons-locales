<?php

namespace App\Controller;

use App\Entity\TProduct;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    //mettre admin truc
    #[Route('/admin/ajout-produit', name: 'add_product')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        //creation product form
        $product = new TProduct();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        //if submitted AND valid
        if($form->isSubmitted() && $form->isValid())
        {
            //save in db
            $manager->persist($product);
            $manager->flush();

            $lastId = $product->getId();
            
            return $this->redirectToRoute('product_show', ['id' => $lastId]);
        }

        return $this->render('admin/addProduct.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }
}
