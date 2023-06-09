<?php

namespace App\Controller;

use DateTime;
use App\Entity\TCart;
use App\Entity\THave;
use App\Entity\TOrder;
use App\Form\OrderType;
use App\Entity\TAddress;
use App\Form\AddressType;
use App\Repository\TCartRepository;
use App\Repository\TTimeRepository;
use App\Repository\TOrderRepository;
use App\Repository\TTitleRepository;
use App\Repository\TStatusRepository;
use App\Repository\TAddressRepository;
use App\Repository\TProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureArgument;


class CartController extends AbstractController
{
    /**
     * This method allows the user to access to his cart page
     * @return Response
     */
    #[Route('utilisateur/panier', name: 'app_user_cart')]
    #[IsGranted('ROLE_USER')]
    public function cart(request $request, EntityManagerInterface $entityManager, TCartRepository $TCartRepository, TProductRepository $TProductRepository, TAddressRepository $TAddressRepository, TTimeRepository $TTimeRepository, TTitleRepository $TTitleRepository, TStatusRepository $TStatusRepository, TOrderRepository $TOrderRepository, RequestStack $RequestStack): Response
    {
        //get current user infos
        $user = $this->getUser();

        //get all user's cart product
        $userCartProducts = $TCartRepository->findBy(['idxUser' => $user]);
    
        //initate count quantity
        $productQuantities = [];

        foreach ($userCartProducts as $userCartProduct) 
        {
            $productId = $userCartProduct->getIdxProduct()->getId();
      
            // If the product already exists in the $productQuantities array, increment the quantity
            if (array_key_exists($productId, $productQuantities))
             {
                $productQuantities[$productId]['quantity'] += 1;
            } 
            // If the product does not exist in the $productQuantities array add it with an initial quantity of 1
            else {
                $productQuantities[$productId] = [
                    'product' => $userCartProduct->getIdxProduct(),
                    'quantity' => 1 // Add the item with an initial quantity of 1
                ];
            }
        }
         
        //get user addresses
        $userAddresses = $TAddressRepository->findBy(['idxUser' => $user]);

        //get journey slice
        $journeySlices = $TTimeRepository->findAll();

        //allows to display the number of product in the cart
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

        //creation order form
        $order = new TOrder();
        $formOrder = $this->createForm(OrderType::class, $order);

        $formOrder->handleRequest($request);

        //if submitted AND valid
        if($formOrder->isSubmitted() && $formOrder->isValid())
        {

            // condition command
            if (!(isset($productQuantities[1]) && $productQuantities[1]['quantity'] >= 2)
            && !(isset($productQuantities[2]) && $productQuantities[2]['quantity'] >= 2)
            && !(isset($productQuantities[1]) && $productQuantities[1]['quantity'] >= 1 && isset($productQuantities[2]) && $productQuantities[2]['quantity'] >= 1)) 
            {
                $this->addFlash(
                    'alert',
                    'Les conditions nécessaires pour passer commande ne sont pas remplies.'
                );
    
                //return on the cart page
                return $this->redirectToRoute('app_user_cart');
            }
                        
            $addressId = $request->request->get('address');
            $address = $TAddressRepository->find($addressId);

            //get status
            $status = $TStatusRepository->find(1);

            $order->setOrdPrice($totalPrice);
            $order->setIdxStatus($status);
            $order->setIdxUser($user);
            $order->setIdxAddress($address);

            $entityManager->persist($order);
            $entityManager->flush();

            //get lastID order
            $lastId = $order->getId();
            $lastOrder = $TOrderRepository->find($lastId);
            
            //foreach link product and last order of the user
            foreach ($userCartProducts as $userCartProduct) {

                $have = new THave();
                $productOrder = $userCartProduct->getIdxProduct();

                $have->setIdxOrder($lastOrder);
                $have->setidxProduct($productOrder);

                $entityManager->persist($have);
                $entityManager->flush();
            }

            //foreach delete quantity product in stock
            foreach ($userCartProducts as $userCartProduct) {

                $productId = $userCartProduct->getIdxProduct();
                $newQuantity = $productId->getProQuantity() - 1;

                $productId->setProQuantity($newQuantity);
                $entityManager->flush();
            }

            //foreach delete product in the cart
            foreach ($userCartProducts as $userCartProduct) {

                $entityManager->remove($userCartProduct);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_show_order', ['id' => $lastId]);
        }

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'textProductCount' => $textProductCount,
            'productQuantities' => $productQuantities,
            'userAddresses' => $userAddresses,
            'journeySlices' => $journeySlices,
            'totalPrice' => $totalPrice,
            'formOrder' => $formOrder->createView()
        ]);
    }
  
    /**
     * This method allows the user to delete an address
     * @return Response
     */    
    #[Route('utilisateur/panier/adresse/ajout', name: 'add_address')]
    #[IsGranted('ROLE_USER')]
    public function add_address(Request $request, TAddressRepository $TAddressRepository, EntityManagerInterface $entityManager): Response
    {
        //get current user infos
        $user = $this->getUser();

        //import google api key
        $google_maps_api_key = 'AIzaSyDPvxNrI_J6sGgaCs02U_GlruqNqCgo_yE';

        //creation address form
        $address = new TAddress();
        $formAddress = $this->createForm(AddressType::class, $address);

        $formAddress->handleRequest($request);

        //if submitted AND valid
        if($formAddress->isSubmitted() && $formAddress->isValid())
        {
            $address->setIdxUser($user);

            $entityManager->persist($address);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'adresse a bien été ajoutée'
            );

            //return on the cart page
            return $this->redirectToRoute('app_user_cart');
        }

        return $this->render('cart/address.html.twig', [
            'controller_name' => 'CartController',
            'google_maps_api_key' => $google_maps_api_key,
            'formAddress' => $formAddress->createView()
        ]);

    }

    /**
     * This method allows the user to delete an address
     * @return Response
     */
    #[Route('utilisateur/panier/adresse/suppression', name: 'delete_address')]
    #[IsGranted('ROLE_USER')]
    public function delete_address(Request $request, TAddressRepository $TAddressRepository, EntityManagerInterface $entityManager): Response
    {
        $idAddress = $request->request->get('address-selection');

        dd($request);
        die();
        $address = $TAddressRepository->find($idAddress);

        $entityManager->remove($address);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'L\'adresse a bien été supprimée'
        );

        //redirect to cart page
        return $this->redirectToRoute('app_user_cart');
    }

    /**
     * This method allows the user to add a product to his cart
     * @return Response
     */
    #[Route('utilisateur/panier/product/{id}/add', name: 'app_user_add_product')]
    #[IsGranted('ROLE_USER')]
    public function add_like(int $id, Request $request, EntityManagerInterface $entityManager, TProductRepository $TProductRepository, RequestStack $requestStack): Response
    {
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
    #[IsGranted('ROLE_USER')]
    public function delete_product_cart(int $id, Request $request, EntityManagerInterface $entityManager, TCartRepository $TCartRepository, TProductRepository $TProductRepository): Response
    {
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
