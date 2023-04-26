<?php

namespace App\Controller;


use SKAgarwal\GoogleApi\PlacesApi;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{

    #[Route('/autocomplete', name: 'app_map_autocomplete')]
    public function autocomplete(Request $request): JsonResponse
    {
        $googlePlaces = new PlacesApi($_ENV["GOOGLE_MAPS_API_KEY"]);
        $input = $request->query->get('input');
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');
        $radius = $request->query->get('radius');

        if (!$radius) {
            $radius = 100;
        }
        $response = $googlePlaces->placeAutocomplete($input, [
            'location' => "$latitude,$longitude",
            'radius' => $radius * 1609.344, // Convert miles to meters
        ]);

        return new JsonResponse($response);
    }

    #[Route('/map', name: 'app_map')]
    public function index(): Response
    {
        return $this->render('user/map/index.html.twig', []);
    }
}