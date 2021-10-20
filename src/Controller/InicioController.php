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
            "doc" => 'API REST Colegio Escribanos:

            Para registar un usuario -> POST https://infinite-inlet-30043.herokuapp.com/register
            Body Json (Ejemplo)-> {
                "username": "escribano",
                "password": "1234",
                "email": "escribano@escribano.com.ar"
            }
            
            Para obtener un JWT Token -> POST https://infinite-inlet-30043.herokuapp.com/api/login_check
            Body Json (Ejemplo) -> {
                "username": "escribano",
                "password": "1234"
            }
            
            Para Obtener un listado de todos los estampillados -> GET https://infinite-inlet-30043.herokuapp.com/api/estampillado
            Authorization: Bearer + Token 
            
            Para crear un estampillado por ahora harcodeado crea siempre el mismo -> POST https://infinite-inlet-30043.herokuapp.com/api/estampillado
            Authorization: Bearer + Token '
        ]);
    }

}
