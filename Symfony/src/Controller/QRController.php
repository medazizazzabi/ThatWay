<?php

namespace App\Controller;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Symfony\Component\Routing\Annotation\Route;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QRController extends AbstractController
{
    #[Route('/qr', name: 'app_QR')]
    public function index(Request $request)
    {
        $id = $request->query->get('id');
        $type = $request->query->get('type');
 
        $jsonData = json_encode(['id' => $id, 'type' => $type]);

        // Set up the QR code generator
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        // Generate the QR code
        $qrCodeString = $writer->writeString($jsonData);
        

        // Create a response with the QR code SVG
        $response = new Response($qrCodeString, Response::HTTP_OK, ['Content-Type' => 'image/svg+xml']);

        return $response;
    }
}
