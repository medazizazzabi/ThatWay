<?php

namespace App\Controller\User;

use App\Entity\Routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RoutestationsRepository;

class RoutesController extends AbstractController
{
    #[Route('/routes', name: 'app_user_routes')]
    public function index(): Response
    {
        //get routes from databse
        $routes = $this->getDoctrine()->getRepository(Routes::class)->findAll();

        return $this->render('user/routes/index.html.twig', [
            'routes' => $routes,
        ]);
    }

    #[Route('/routes/{id}', name: 'app_user_routes_show')]
    public function show(Routes $route, RouteStationsRepository $routestationsRepository): Response
    {
        $routeStations = $routestationsRepository->findByRoute($route);
        return $this->render('user/routes/show.html.twig', [
            'route' => $route,
            'routeStations' => $routeStations,
        ]);
    }
}
