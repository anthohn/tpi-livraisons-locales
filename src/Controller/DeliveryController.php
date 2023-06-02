<?php

namespace App\Controller;

use App\Repository\TTimeRepository;
use App\Repository\TOrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeliveryController extends AbstractController
{
    /**
     * This method allow an admin to access to the delivery map
     * @return Response
     */
    #[Route('/delivery', name: 'app_delivery')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, TTimeRepository $TTimeRepository, TOrderRepository $TOrderRepository): Response
    {
        $slices = $TTimeRepository->FindAll();

        $orders = NULL;
        $google_maps_api_key = NULL;

        // if form if submit
        if ($request->isMethod('POST')) {

            // get the date of the request
            $formDate = $request->request->get('date');

            // get the slice of the request
            $formSlice = $request->request->get('checkSlice');

            //convert the date to a DateTime object
            $dateObj = new \DateTime($formDate);            

            // get time table slice
            $slice = $TTimeRepository->Find($formSlice);

            // find orders by date and time
            $orders = $TOrderRepository->findBy([
                'ordDate' => $dateObj,
                'idxTime' => $slice
            ]);

            // get time table slice
            $slices = $TTimeRepository->FindAll();

            // api key
            $google_maps_api_key = '';

            //redirect with orders
            return $this->render('delivery/index.html.twig', [
                'controller_name' => 'DeliveryController',
                'orders' => $orders,
                'slices' => $slices,
                'google_maps_api_key' => $google_maps_api_key
            ]);     
        }

        return $this->render('delivery/index.html.twig', [
            'controller_name' => 'DeliveryController',
            'orders' => $orders,
            'slices' => $slices,
            'google_maps_api_key' => $google_maps_api_key
        ]);
    }
}
