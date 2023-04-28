<?php

namespace App\Controller\User;

use App\Entity\Routes;
use App\Entity\Routestations;
use App\Repository\RoutestationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoutesController extends AbstractController
{
    #[Route('/routes', name: 'app_user_routes')]
    public function index(): Response
    {
        //get routes from databse
        $routes = $this->getDoctrine()->getRepository(Routes::class)->findAll();
        //add to the each route from Routestations the station name from sequence 0 and the last one
        foreach ($routes as $route) {
            $routeStations = $this->getDoctrine()->getRepository(Routestations::class)->findBy(['routeid' => $route->getId()]);
            //loop through the routeStations and check if there is any close or under construction station
            foreach ($routeStations as $routeStation) {
                if ($routeStation->getStationid()->getStatus() == "closed") {
                    $route->setStatus("closed");
                    break;
                } else if ($route->setStatus("under_constriction")) {
                    $route->setStatus("under_constriction");
                    break;
                } else {
                    $route->setStatus("active");
                }
            }
            $route->setStartstationid($routeStations[0]->getStationid());
            $route->setEndstationid($routeStations[count($routeStations) - 1]->getStationid());
        }

        return $this->render('user/routes/index.html.twig', [
            'routes' => $routes,
        ]);
    }

    #[Route('/routes/{id}', name: 'app_user_routes_show')]
    public function show(Routes $route, RouteStationsRepository $routestationsRepository): Response
    {
        $routeStations = $this->getDoctrine()->getRepository(Routestations::class)->findBy(['routeid' => $route->getId()]);
        //loop through the routeStations and check if there is any close or under construction station
        foreach ($routeStations as $routeStation) {
            if ($routeStation->getStationid()->getStatus() == "closed") {
                $route->setStatus("closed");
                break;
            } else if ($route->setStatus("under_constriction")) {
                $route->setStatus("under_constriction");
                break;
            } else {
                $route->setStatus("active");
            }
        }
        $route->setStartstationid($routeStations[0]->getStationid());
        $route->setEndstationid($routeStations[count($routeStations) - 1]->getStationid());
        return $this->render('user/routes/show.html.twig', [
            'route' => $route,
            'routeStations' => $routeStations,
        ]);
    }
}
