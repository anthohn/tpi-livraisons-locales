<?php

namespace App\Controller;

use DateTime;
use App\Entity\TCart;
use App\Entity\TAddress;
use App\Form\AddressType;
use App\Repository\TCartRepository;
use App\Repository\TTimeRepository;
use App\Repository\TTitleRepository;
use App\Repository\TAddressRepository;
use App\Repository\TProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureArgument;


class CartController extends AbstractController
{
    /**
     * This method allows the user to access to his cart page
     * @return Response
     */
    #[Route('utilisateur/panier', name: 'app_user_cart')]
    public function cart(request $request, EntityManagerInterface $manager, TCartRepository $TCartRepository, TAddressRepository $TAddressRepository, TTimeRepository $TTimeRepository, TTitleRepository $TTitleRepository, RequestStack $RequestStack): Response
    {
        //check if the user is logged in, otherwise redirect to the login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get current user infos
        $user = $this->getUser();

        //get all user's cart product
        $userCartProducts = $TCartRepository->findBy(['idxUser' => $user]);
         
        //get user addresses
        $userAddresses = $TAddressRepository->findBy(['idxUser' => $user]);

        //get journey slice
        $journeySlices = $TTimeRepository->findAll();

        //get personn title
        $titles = $TTitleRepository->findAll();

        //allows to display the number of items with s or not
        $productCount = count($userCartProducts);

        //calculate the total price of the cart
        $totalPrice = 0;
        foreach ($userCartProducts as $userCartProduct) {
            $totalPrice += $userCartProduct->getIdxProduct()->getProPrice();
        }

        //in one prodcut display : "acrticlE" if multiple products -> "articlES"
        if ($productCount > 1) {
            $textProductCount = sprintf('(%d articles)', $productCount);
        }
        else {
            $textProductCount = sprintf('(%d article)', $productCount);
        }

        //import google api key
        $google_maps_api_key = '';

        //creation address form
        $address = new TAddress();
        $formAddress = $this->createForm(AddressType::class, $address);

        $formAddress->handleRequest($request);

        //if submitted AND valid
        if($formAddress->isSubmitted() && $formAddress->isValid())
        {
            $address->setIdxUser($user);

            $manager->persist($address);
            $manager->flush();

            //return on the cart page
            return $this->redirectToRoute('app_user_cart');
        }

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'textProductCount' => $textProductCount,
            'userCartProducts' => $userCartProducts,
            'userAddresses' => $userAddresses,
            'journeySlices' => $journeySlices,
            'titles' => $titles,
            'totalPrice' => $totalPrice,
            'google_maps_api_key' => $google_maps_api_key,
            'formAddress' => $formAddress->createView()
        ]);
    }

    /**
     * This method allows the user to add a product to his cart
     * @return Response
     */
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

    /**
     * This method allows the user to remove a product of his cart
     * @return Response
     */
    #[Route('utilisateur/panier/product/{id}/delete', name: 'app_user_delete_product')]
    public function delete_product_cart(int $id, Request $request, EntityManagerInterface $entityManager, TCartRepository $TCartRepository, TProductRepository $TProductRepository): Response
    {
        //check if the user is logged in, otherwise redirect to the login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get current user infos
        $user = $this->getUser();
    
        //get the cart product to delete
        $cartProduct = $TCartRepository->findOneBy(['idxProduct' => $id]);

        //if an other user attempt to get in this page he get redirect to the home page
        if ($cartProduct->getIdxUser() !== $user) {
            return $this->redirectToRoute('home');
        }

        //delete cart product
        $entityManager->remove($cartProduct);
        $entityManager->flush();

        //redirect to page liked product
        return $this->redirectToRoute('app_user_cart');
    }
}
