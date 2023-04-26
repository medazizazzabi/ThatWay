<?php

namespace App\Controller\Admin;

use App\Entity\Routes;
use App\Entity\Stations;
use App\Form\RoutesType;
use App\Entity\Routestations;
use App\Form\RoutestationsType;
use App\Repository\RoutestationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class RoutesController extends AbstractController
{
    #[Route('/routes', name: 'app_admin_routes')]
    public function index(): Response
    {
        //get routes from databse
        $routes = $this->getDoctrine()->getRepository(Routes::class)->findAll();

        return $this->render('admin/routes/index.html.twig', [
            'routes' => $routes,
        ]);
    }

    #[Route('/routes/new', name: 'app_admin_routes_new')]
    public function new(Request $request): Response
    {
        $route = new Routes();
        $form = $this->createForm(RoutesType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($route);
            $entityManager->flush();

            $this->addFlash('success', 'Route created successfully.');

            return $this->redirectToRoute('app_admin_routes');
        }

        return $this->render('admin/routes/create.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/routes/{id}', name: 'app_admin_routes_show')]
    public function show(Routes $route, RouteStationsRepository $routestationsRepository): Response
    {
        $routeStations = $routestationsRepository->findByRoute($route);

        return $this->render('admin/routes/show.html.twig', [
            'route' => $route,
            'routeStations' => $routeStations,
        ]);
    }

    #[Route('/routes/{id}/edit', name: 'app_admin_routes_edit')]
    public function edit(Request $request, Routes $route): Response
    {
        $form = $this->createForm(RoutesType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            $this->addFlash('success', 'Route updated successfully.');

            return $this->redirectToRoute('app_admin_routes');
        }

        return $this->render('admin/routes/edit.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/routes/{id}/delete', name: 'app_admin_routes_delete')]
    public function delete(Routes $route): Response
    {
        //delete route from database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($route);
        $entityManager->flush();

        $this->addFlash('success', 'Route deleted successfully.');


        return $this->redirectToRoute('app_admin_routes');
    }

    #[Route('/routes/{id}/stations', name: 'app_admin_routes_stations', methods: ['GET', 'POST'])]
    public function stations(Routes $route, Request $request, RouteStationsRepository $routestationsRepository): Response
    {
        $routeStations = $routestationsRepository->findByRoute($route);

        $routeStation = new Routestations();
        $routeStation->setRouteid($route);

        $stations = $this->getDoctrine()->getRepository(Stations::class)->findAll();
        $stationsInRoute = [];
        foreach ($routeStations as $routeStation) {
            $stationsInRoute[] = $routeStation->getStationid()->getId();
        }
        $availableStations = [];
        foreach ($stations as $station) {
            if (!in_array($station->getId(), $stationsInRoute)) {
                $availableStations[] = $station;
            }
        }
/*
Station Entity
private $id;
private $name;
private $mode;
private $location;
private $status;
private $accessibilityfeatures = '\'none\'';
private $facilities = '\'none\'';
private $operatinghours = 'NULL';
*/

/*
private $id;
private $sequencenumber;
private $stationid;
private $routeid;
*/

        if ($request->isMethod('POST') && $request->isXmlHttpRequest()) {
            $routeStationsData = [];
            foreach ($routeStations as $routeStation) {
                $routeStationsData[] = [
                    'pathId' => $routeStation->getId(),
                    'stationId' => $routeStation->getStationid()->getId(),
                    'stationName' => $routeStation->getStationid()->getName(),
                    'stationMode' => $routeStation->getStationid()->getMode(),
                    'stationStatus' => $routeStation->getStationid()->getStatus(),
                    'stationAccessibilityFeatures' => $routeStation->getStationid()->getAccessibilityfeatures(),
                    'stationFacilities' => $routeStation->getStationid()->getFacilities(),
                    'stationOperatinghours' => $routeStation->getStationid()->getOperatinghours()
                    
                ];
            }

            $availableStationsData = [];
            foreach ($availableStations as $station) {
                $availableStationsData[] = [
                    'stationId' => $station->getId(),
                    'stationName' => $station->getName()
                ];
            }
            $data = [
                'route' => [
                    'id' => $route->getId(),
                    'name' => $route->getName()
                ],
                'routeStations' => $routeStationsData,
                'availableStations' => $availableStationsData,
            ];
            return new JsonResponse($data);
        }


        return $this->render('admin/routestations/path.html.twig', [
            'route' => $route,
            'routeStations' => $routeStations,
            'availableStations' => $availableStations,
        ]);
    }
}
