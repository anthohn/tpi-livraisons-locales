<?php

namespace App\Controller;

use App\Repository\THaveRepository;
use App\Repository\TOrderRepository;
use App\Repository\TAddressRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * This method allows the user to view all his commands
     * @return Response
     */
    #[Route('utilisateur/commandes', name: 'app_order')]
    #[IsGranted('ROLE_USER')]
    public function orders(TOrderRepository $TOrderRepository): Response
    {
        //vérifie si l'utilisateur est connecté, sinon redirection vers le login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get the current user
        $user = $this->getUser();

        $userOrders = $TOrderRepository->findBy(['idxUser' => $user]);

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'userOrders' => $userOrders
        ]);
    }

    /**
     * This method allows the user view the details of a command
     * @return Response
     */
    #[Route('utilisateur/commande-details/{id}', name: 'app_show_order')]
    #[IsGranted('ROLE_USER')]
    public function show_order(int $id, TOrderRepository $TOrderRepository, THaveRepository $THaveRepository, TAddressRepository $TAddressRepository): Response
    {
        //vérifie si l'utilisateur est connecté, sinon redirection vers le login
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //get the current user
        $user = $this->getUser();

        $userId = $user->getId();

        //get the order by id in url
        $userOrder = $TOrderRepository->find($id);
        
        //get product of the order
        $orderPoducts = $THaveRepository->FindBy(['idxOrder' => $userOrder]);

        $google_maps_api_key = 'AIzaSyDPvxNrI_J6sGgaCs02U_GlruqNqCgo_yE';

        return $this->render('order/show.html.twig', [
            'controller_name' => 'OrderController',
            'userOrder' => $userOrder,
            'orderPoducts' => $orderPoducts,
            'userId' => $userId,
            'google_maps_api_key' => $google_maps_api_key
        ]);
    }
}
