<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Bienvenido al servicio REST del colegio de escribanos!',
            "endpoints" => [
                "Registar un usuario" => [
                    "protocolo" => "POST",
                    "url" => "/register",
                    "body json" => [
                        "username" => "escribano",
                        "password" => "1234",
                        "email" => "escribano@escribano.com.ar"
                    ],
                    "response" => "Http Code 201 Created"
                ],
                "Obtener JWT Token" => [
                    "protocolo" => "POST",
                    "url" => "/api/login_check",
                    "body json" => [
                        "username" => "escribano",
                        "password" => "1234"
                    ],
                    "response" => [
                        "token" => "Encoded token (expired in 3600 seconds)"
                    ]
                ],
                "Crear el estampillado de un estatuto" => [
                    "protocolo" => "POST",
                    "url" => "/api/estampillado",
                    "header" => "Authorization: Bearer + Token retornado en '/api/login_check'",
                    "body json" => [
                        "estatuto" => "base64 encoded File Document",
                        "num_expediente" => "RO-589-8510",
                        "url_organismo_solicitante" => "localhost"
                    ],
                    "response" => [
                        "hash" => "f8995a735919f4146f5dbc39f112c9f9"
                    ]
                ],
                "Listar todos los estampillados" => [
                    "protocolo" => "GET",
                    "url" => "/api/estampillado",
                    "header" => "Authorization: Bearer + Token retornado en '/api/login_check'",
                    "response (Listado de estampillados)" => [
                        "num_expediente" => "RO-589-85112",
                        "hash" => "f8995a735919f4146f5dbc39f112c9f9",
                        "qr" => "base64 encoded PNG Image"
                    ]
                ],
                "Obtener un espampillado por hash" => [
                    "protocolo" => "GET",
                    "url" => "/api/estampillado/{hash}",
                    "header" => "Authorization: Bearer + Token retornado en '/api/login_check'",
                    "response" => [
                        "num_expediente" => "RO-589-85112",
                        "hash" => "f8995a735919f4146f5dbc39f112c9f9",
                        "qr" => "base64 encoded PNG Image"
                    ]
                ],
            ]
        ]);
    }

}
