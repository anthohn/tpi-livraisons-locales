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
        return $this->redirectToRoute('app_home');
    }

    #[Route('/accueil', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/produits', name: 'app_product')]
    public function product(TProductRepository $TProductRepository): Response
    {
        // get all products
        $products = $TProductRepository->findAll();


        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }
}
