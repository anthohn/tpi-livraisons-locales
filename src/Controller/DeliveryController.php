<?php

namespace App\Controller;

use DateTime;
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
    public function index(Request $request, TTimeRepository $TTimeRepository, THaveRepository $THaveRepository, TOrderRepository $TOrderRepository, Environment $twig): Response
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
            $europeanFormat = $dateObj->format('d.m.y');

            // get time table slice
            $slice = $TTimeRepository->Find($formSlice);

            $sliceName = $slice->getTimSlice();

            // find orders by date and time
            $orders = $TOrderRepository->findBy([
                'ordDate' => $dateObj,
                'idxTime' => $slice
            ]);

            // get time table slice
            $slices = $TTimeRepository->FindAll();
            
            // api key
            $google_maps_api_key = 'AIzaSyDPvxNrI_J6sGgaCs02U_GlruqNqCgo_yE';

            //redirect with orders
            return $this->render('delivery/index.html.twig', [
                'controller_name' => 'DeliveryController',
                'orders' => $orders,
                'slice' => $slice,
                'slices' => $slices,
                'sliceName' => $sliceName,
                'google_maps_api_key' => $google_maps_api_key,
                'europeanFormat' => $europeanFormat,
                'formDate' => $formDate,
                'formSlice' => $formSlice
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

    /**
     * This method allow an admin to generate pdf on delivery
     * @return Response
     */
    #[Route('/delivery/pdf/{date}/{slice}', name: 'app_delivery_pdf')]
    #[IsGranted('ROLE_ADMIN')]
    public function generatePdfDelivery(Request $request, DateTime $date, int $slice, TOrderRepository $TOrderRepository, THaveRepository $THaveRepository, TTimeRepository $TTimeRepository): Response
    {
           // find orders by date and time
           $orders = $TOrderRepository->findBy([
            'ordDate' => $date,
            'idxTime' => $slice
        ]);

        $sliceName = $TTimeRepository->find($slice)->getTimSlice();

        $europeanFormat = $date->format('d.m.y');

        $productsAndAddresses = [];

        foreach ($orders as $order) {
            $orderId = $order->getId();
        
            $haves = $THaveRepository->findBy([
                'idxOrder' => $orderId,
            ]);
        
            $address = $order->getIdxAddress()->getAddAddress();
            $useFirstName = $order->getIdxAddress()->getAddFirstName();
            $useLastName = $order->getIdxAddress()->getAddLastName();

            $productsCount = [];
        
            foreach ($haves as $have) {
                $product = $have->getIdxProduct();
                $productName = $product->getProName();
        
                if (isset($productsCount[$productName])) {
                    $productsCount[$productName]++;
                } else {
                    $productsCount[$productName] = 1;
                }
            }
        
            $productsAndAddresses[$orderId] = [
                'address' => $address,
                'productsCount' => $productsCount,
                'useFirstName' => $useFirstName,
                'useLastName' => $useLastName
            ];
        }
        
        $dompdf = new Dompdf();
        
        // Render the Twig template with the orders variable
        $dompdf->load_html($this->renderView('delivery/pdfTemplate.html.twig', [
            'productsAndAddresses' => $productsAndAddresses,
            'sliceName' => $sliceName,
            'europeanFormat' => $europeanFormat
        ]));

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

        dump($dompdf);
        die();

        return $this->render('delivery/index.html.twig', [
            'controller_name' => 'DeliveryController',
        ]);
    }

}
