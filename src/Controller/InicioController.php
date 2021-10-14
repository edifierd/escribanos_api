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
        ]);
    }

}
