<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Twig\Environment;
use App\Repository\THaveRepository;
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
    public function index(Request $request, TTimeRepository $TTimeRepository, THaveRepository $THaveRepository, Environment $twig): Response
    {
        $slices = $TTimeRepository->FindAll();
        $orders = NULL;
        $google_maps_api_key = NULL;
        $europeanFormat = NULL;

        // if form if submit
        if ($request->isMethod('POST')) {

            // get the date of the request
            $formDate = $request->request->get('date');

            // get the slice of the request
            $formSlice = $request->request->get('checkSlice');

            //convert the date to a DateTime object
            $dateObj = new \DateTime($formDate);              

            // convert the date to the European format
            $europeanFormat = $dateObj->format('Y-m-d');

            // get time table slice
            $slice = $TTimeRepository->Find($formSlice);

            $sliceName = $slice->getTimSlice();

            // // find orders by date and time
            // $orders = $TOrderRepository->findBy([
            //     'ordDate' => $dateObj,
            //     'idxTime' => $slice
            // ]);

             // find orders by date and time
             $orders = $THaveRepository->findBy([
                'idxOrder' => [
                    'ordDate' => $dateObj
                ]
            ]);

            dump($orders);


            // get time table slice
            $slices = $TTimeRepository->FindAll();
            

            // api key
            $google_maps_api_key = 'AIzaSyDPvxNrI_J6sGgaCs02U_GlruqNqCgo_yE';




            $dompdf = new Dompdf();
            // Render the Twig template with the orders variable
            $dompdf->load_html($this->renderView('delivery/pdfTemplate.html.twig', [
                'orders' => $orders,
                'europeanFormat' => $europeanFormat,
                'sliceName' => $sliceName
            ]));

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();


            
            //redirect with orders
            return $this->render('delivery/index.html.twig', [
                'controller_name' => 'DeliveryController',
                'orders' => $orders,
                'slices' => $slices,
                'sliceName' => $sliceName,
                'google_maps_api_key' => $google_maps_api_key,
                'europeanFormat' => $europeanFormat
            ]);     
        }

        return $this->render('delivery/index.html.twig', [
            'controller_name' => 'DeliveryController',
            'orders' => $orders,
            'slices' => $slices,
            'google_maps_api_key' => $google_maps_api_key,
            'europeanFormat' => $europeanFormat
        ]);
    }

    #[Route('/delivery/pdf', name: 'app_delivery_pdf')]
    #[IsGranted('ROLE_ADMIN')]
    public function generatePdfPersonne(Request $request, TOrderRepository $TOrderRepository, TTimeRepository $TTimeRepository): Response
    {
        // get the date of the request
        $formDate = $request->request->get('date');


        //convert the date to a DateTime object
        $dateObj = new \DateTime($formDate);   
        

        // get the slice of the request
        $formSlice = 1;

        // get time table slice
        $slice = $TTimeRepository->Find($formSlice);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->load_html($this->renderView('delivery/index.html.twig', [
            'test' => $TOrderRepository->findBy([
                'ordDate' => $dateObj,
                'idxTime' => $slice
        ])]));



// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();



    }

}
