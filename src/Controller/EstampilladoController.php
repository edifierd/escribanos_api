<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Estampillados;

/**
 * @return JsonResponse
 * @Route("/api/estampillado", name="api_estampillado")
 */
class EstampilladoController extends AbstractController
{

    /**
     * @return JsonResponse
     * @Route("", name="get_estampillado", methods={"GET"})
     */
    public function getEstampillados(){
        $entityManager = $this->getDoctrine()->getManager();
        $estampillados = $entityManager->getRepository(Estampillados::class)->findAll();

        $rta=[];
        foreach ($estampillados as $key => $value) {
            $rta[] = [
                "num_expediente" => $value->getNumExpediente(),
                "hash" => $value->getHash(),
            ];
        }
        return new JsonResponse($rta, 200);
    }

    /**
     * @return JsonResponse
     * @Route("", name="new_estampillado", methods={"POST"})
     */
    public function createEstampillado(){
        $entityManager = $this->getDoctrine()->getManager();

        $estampillado = new Estampillados();
        $estampillado->setEstatuto("dvdsfvbas");
        $estampillado->setNumExpediente("dvdsfvbas");
        $estampillado->setHash("dvdsfvbas");
        $entityManager->persist($estampillado);
        $entityManager->flush();

        return $this->json([
            "hash" => $estampillado->getHash()
        ]);
    }
}
