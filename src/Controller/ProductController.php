<?php

namespace App\Controller;

use App\Repository\TProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function Redirection()
    {
        //redirect to home page
        return $this->redirectToRoute('app_home');
    }

    #[Route('/accueil', name: 'app_home')]
    public function index(): Response
    {
        // home page
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/produits', name: 'app_products')]
    public function products(TProductRepository $TProductRepository): Response
    {
        // get all products in db
        $products = $TProductRepository->findAll();


        return $this->render('product/products.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    #[Route('/produit/{id}', name: 'product_show')]
    public function show(int $id, TProductRepository $TProductRepository): Response
    {
        //retrieve the product via given id
        $product = $TProductRepository->find($id);
        
        //Check if $product is valid and redirect to home if null
        if (!$product) {
            return $this->redirectToRoute('home');
        }
      
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product
        ]);
    }
    
}
