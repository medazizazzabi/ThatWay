<?php

namespace App\Controller;

use App\Entity\Routes;
use App\Entity\Stations;

use App\Entity\Routestations;
use SKAgarwal\GoogleApi\PlacesApi;
use App\Service\GooglePlacesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MapController extends AbstractController
{
    private $googlePlacesService;

    public function __construct()
    {
        $this->googlePlacesService = new GooglePlacesService($_ENV["GOOGLE_MAPS_API_KEY"]);
    }


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

        $jsonResponse = new JsonResponse($response);

        return $jsonResponse;
    }

    #[Route('/map', name: 'app_map')]
    public function index(): Response
    {
        return $this->render('user/map/index.html.twig', []);
    }
    //given a location coordinates find the nearest Station to it from the database
    public function findNearestStation($latitude, $longitude)
    {
        $stations = $this->getDoctrine()->getRepository(Stations::class)->findAll();
        $nearestStation = null;
        $nearestDistance = 1000000;
        foreach ($stations as $station) {
            if ($station->getLocation() != null) {
                $location = $station->getLocation();
                $location = explode(' ', $location);
                $latitude1 = explode('(', $location[0])[1];
                $longitude1 = explode(')', $location[1])[0];
                $distance = $this->distance($latitude, $longitude, $latitude1, $longitude1);
                if ($distance < $nearestDistance) {
                    $nearestDistance = $distance;
                    $nearestStation = $station;
                }
            }
        }
        return $nearestStation;
    }

    //calculate the distance between two points on the map
    public function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $earthRadius = 6371000;
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }



    public function findRoutes($station)
    {
        $routesStations = $this->getDoctrine()->getRepository(Routestations::class)->findAll();
        $routes = [];
        foreach ($routesStations as $routeStation) {
            if ($routeStation->getStationid() == $station) {
                $routes[] = $this->getDoctrine()->getRepository(Routes::class)->findBy(['id' => $routeStation->getRouteID()]);
            }
        }
        return $routes;
    }

    function findPath(EntityManagerInterface $entityManager, string $startStationName, string $endStationName): array
    {
        // Find the start and end stations in the database
        $startStation = $entityManager->getRepository(Stations::class)->findOneBy(['name' => $startStationName]);
        $endStation = $entityManager->getRepository(Stations::class)->findOneBy(['name' => $endStationName]);
        // Find all route stations that contain the start and end stations
        $startRouteStations = $entityManager->getRepository(Routestations::class)->findBy(['stationid' => $startStation->getID()]);
        $endRouteStations = $entityManager->getRepository(Routestations::class)->findBy(['stationid' => $endStation->getID()]);

        // Loop through each possible starting route station
        foreach ($startRouteStations as $startRouteStation) {
            // Loop through each possible ending route station
            foreach ($endRouteStations as $endRouteStation) {
                // If the start and end route stations belong to the same route
                if ($startRouteStation->getRouteID() == $endRouteStation->getRouteID()) {
                    // Find the route and all its stations
                    $route = $entityManager->getRepository(Routes::class)->findOneBy(['id' => $startRouteStation->getRouteID()]);
                    $routeStations = $entityManager->getRepository(Routestations::class)->findBy(['routeid' => $route->getID()], ['sequencenumber' => 'ASC']);
                    $stationNames = [];
                    $foundStartStation = false;
                    $foundEndStation = false;
                    foreach ($routeStations as $routeStation) {
                        if ($routeStation->getStationid() == $startStation) {
                            $foundStartStation = true;
                        }
                        if ($foundStartStation && !$foundEndStation) {
                            $station = $entityManager->getRepository(Stations::class)->findOneBy(['id' => $routeStation->getStationID()]);
                            $stationNames[] = $station->getName();
                            if ($station->getID() == $endStation->getID()) {
                                $foundEndStation = true;
                                break;
                            }
                        }
                    }
                    if ($foundEndStation) {
                        return $stationNames;
                    }
                }
            }
        }
        foreach ($startRouteStations as $startRouteStation) {
            // Loop through each possible ending route station
            foreach ($endRouteStations as $endRouteStation) {
                // If the start and end route stations belong to the same route
                if ($startRouteStation->getRouteID() == $endRouteStation->getRouteID()) {
                    // Find the route and all its stations
                    $route = $entityManager->getRepository(Routes::class)->findOneBy(['id' => $startRouteStation->getRouteID()]);
                    $routeStations = $entityManager->getRepository(Routestations::class)->findBy(['routeid' => $route->getID()], ['sequencenumber' => 'DESC']);
                    $stationNames = [];
                    $foundStartStation = false;
                    $foundEndStation = false;
                    foreach ($routeStations as $routeStation) {
                        if ($routeStation->getStationid() == $startStation) {
                            $foundStartStation = true;
                        }
                        if ($foundStartStation && !$foundEndStation) {
                            $station = $entityManager->getRepository(Stations::class)->findOneBy(['id' => $routeStation->getStationID()]);
                            $stationNames[] = $station->getName();
                            if ($station->getID() == $endStation->getID()) {
                                $foundEndStation = true;
                                break;
                            }
                        }
                    }
                    if ($foundEndStation) {
                        return $stationNames;
                    }
                }
            }
        }


        // If no path was found, return an empty array to indicate a gap in the path
        return [];
    }

    //given an array of stations names return the array of stations objects
    public function getStations($stationsNames)
    {
        $stations = [];
        foreach ($stationsNames as $stationName) {
            $stations[] = $this->getDoctrine()->getRepository(Stations::class)->findOneBy(['name' => $stationName]);
        }
        return $stations;
    }

    //use /findstations?startid=idstation1&endid=idstation2 and get the station names use the findPath function to find the path between the two stations
    #[Route('/findstations', name: 'app_map_findstations')]
    public function findStations(Request $request): JsonResponse
    {
        $startplaceId = $request->query->get('startid');
        $endplaceId = $request->query->get('endid');
        $startStation = $this->findNearestStation($this->placeIdToLatLong($startplaceId)["latitude"], $this->placeIdToLatLong($startplaceId)["longitude"]);
        $endStation = $this->findNearestStation($this->placeIdToLatLong($endplaceId)["latitude"], $this->placeIdToLatLong($endplaceId)["longitude"]);
        dump($startStation);
        dump($endStation);

        $startStationName = $startStation->getName();
        $endStationName = $endStation->getName();
        dump($startStationName);
        dump($endStationName);
        $path = $this->findPath($this->getDoctrine()->getManager(), $startStationName, $endStationName);
        dump($path);
        $path = $this->getStations($path);
        //convert the array of stations objects to an json array of stations names and ids and location
        $stations = [];
        foreach ($path as $station) {
            //convert location point to lat and long
            $location = $station->getLocation();
            $location = explode(' ', $location);
            $longitude = explode('(', $location[0])[1];
            $latitude = explode(')', $location[1])[0];
            $stations[] = ['id' => $station->getId(), 'name' => $station->getName(), 'longitude' => $longitude, 'latitude' => $latitude];
        }
        $jsonResponse = new JsonResponse($stations);
        return $jsonResponse;
    }

    //latlong to place id
    public function latLongToPlaceId($lat, $long)
    {
        $placeId = $this->googlePlacesService->getPlaceIdFromCoordinates($lat, $long);

        if ($placeId) {
            return $placeId;
        } else {
            return null;
        };
    }

    //plcae id to lat and long
    public function placeIdToLatLong($placeId)
    {
        $coordinates = $this->googlePlacesService->getCoordinatesFromPlaceId($placeId);

        if ($coordinates) {
            return $coordinates;
        } else {
            return null;
        };
    }

    //write a function that will return the location of all stations
    #[Route('/getstations', name: 'app_map_getstations')]
    public function getStationsLocation(): JsonResponse
    {
        $stations = $this->getDoctrine()->getRepository(Stations::class)->findAll();
        $stationsLocation = [];
        foreach ($stations as $station) {
            $location = $station->getLocation();
            if ($location) {
                $location = explode(' ', $location);
                $longitude = explode('(', $location[0])[1];
                $latitude = explode(')', $location[1])[0];
                $stationsLocation[] = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
            }
        }
        $jsonResponse = new JsonResponse($stationsLocation);
        return $jsonResponse;
    }
}
