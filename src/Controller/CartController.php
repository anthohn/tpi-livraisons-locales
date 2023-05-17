<?php

namespace App\Controller;

use DateTime;
use App\Entity\TCart;
use App\Repository\TCartRepository;
use App\Repository\TProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CartController extends AbstractController
{
    #[Route('utilisateur/panier', name: 'app_user_cart')]
    public function cart(TCartRepository $TCartRepository): Response
    {
        //check if the user is logged in, otherwise redirect to the login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get current user infos
        $user = $this->getUser();

        //get all user's liked product
        $userCartProducts = $TCartRepository->findBy(['idxUser' => $user]);


        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('utilisateur/panier/product/{id}/add', name: 'app_user_add_product')]
    public function add_like(int $id, Request $request, EntityManagerInterface $entityManager, TProductRepository $TProductRepository, RequestStack $requestStack): Response
    {
        //check if the user is logged in, otherwise redirect to the login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get current user infos
        $user = $this->getUser();
    
        //get the product he want to add into cart
        $product = $TProductRepository->find($id);

        //new cart initalise
        $cart = new TCart();
        $cart->setIdxProduct($product);
        $cart->setIdxUser($user);
        $cart->setCarAddedDate(new DateTime());

        //save in db
        $entityManager->persist($cart);
        $entityManager->flush();

        //return on the last page the user was
        $lastUrl = $requestStack->getCurrentRequest()->headers->get('referer');
        return new RedirectResponse($lastUrl);
    }
}
