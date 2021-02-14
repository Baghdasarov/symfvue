<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Review;
use App\Repository\HotelRepository;
use App\Repository\ReviewRepository;
use DateTimeImmutable;
use Exception;
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
    public function index(): Response
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

    /**
     * @Route("/reviews/{id}", name="hotels.reivews")
     * @var int $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function reviews(int $id, Request $request): JsonResponse
    {
        /** @var HotelRepository $hotelRepository */
        $hotelRepository = $this->getDoctrine()->getRepository(Hotel::class);

        $hotel = $hotelRepository->find($id);

        if ($hotel === null) {
            return new JsonResponse(['message' => 'not found'], 404);
        }

        $from = $request->get('from') ? new DateTimeImmutable($request->get('from')) : null;
        $to = $request->get('to') ? new DateTimeImmutable($request->get('to')) : null;

        /** @var ReviewRepository $reviewRepository */
        $reviewRepository = $this->getDoctrine()->getRepository(Review::class);

        return new JsonResponse($reviewRepository->getGroupedScoreForHotel($hotel, $from, $to));
    }
}
