<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

    /**
     * @Route("/hotels", name="hotels")
     * @return Response
     */
    public function hotels(): Response
    {
        /** @var HotelRepository $hotelRepository */
        $hotelRepository = $this->getDoctrine()->getRepository(Hotel::class);
        $models = $hotelRepository->findAll();
        $data = [];

        foreach ($models as $hotel) {
            $data[$hotel->getId()] = $hotel->getName();
        }

        return new JsonResponse(compact('data'));
    }
}
