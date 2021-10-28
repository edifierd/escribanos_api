<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Estampillado;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

/**
 * @return JsonResponse
 * @Route("/api/estampillado", name="api_estampillado")
 */
class EstampilladoController extends ApiController
{
  
    /**
     * @return JsonResponse
     * @Route("/{hash}", name="get_estampillado_by_hash", methods={"GET"})
     */
    public function getEstampillado($hash){
        $entityManager = $this->getDoctrine()->getManager();
        $estampillado = $entityManager->getRepository(Estampillado::class)->findOneBy(['hash' => $hash]);

        return $this->response([
            "num_expediente" => $estampillado->getNumExpediente(),
            "hash" => $estampillado->getHash(),
            "qr" => $estampillado->getQr(),
        ]);
    }


    /**
     * @return JsonResponse
     * @Route("", name="get_estampillados", methods={"GET"})
     */
    public function getEstampillados(){
        $entityManager = $this->getDoctrine()->getManager();
        $estampillados = $entityManager->getRepository(Estampillado::class)->findAll();

        $rta=[];
        foreach ($estampillados as $key => $value) {
            $rta[] = [
                "num_expediente" => $value->getNumExpediente(),
                "hash" => $value->getHash(),
                "qr" => $value->getQr(),
            ];
        }
        return $this->response($rta);
    }

    /**
     * @return JsonResponse
     * @Route("", name="new_estampillado", methods={"POST"})
     */
    public function createEstampillado(Request $request){
        $request = $this->transformJsonBody($request);
        $estatuto = $request->get('estatuto');
        $num_expediente = $request->get('num_expediente');
        $urlBase = $request->get('url_organismo_solicitante');

        if(
            $estatuto == null || trim($estatuto) == '' ||
            $num_expediente == null || trim($num_expediente) == '' ||
            $urlBase == null || trim($urlBase) == ''
        ){
            return $this->respondValidationError("Todos los parametros son obligatorios");
        }

        if(!$this->is_base64($estatuto)){
            return $this->respondValidationError("El estatuto parece no ser un archivo válido");
        }

        $hash = md5(random_bytes(20));
        $qr = base64_encode($this->generateQr($urlBase."/".$hash));
        
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $estampillado = new Estampillado();
            $estampillado->setEstatuto($estatuto);
            $estampillado->setNumExpediente($num_expediente);
            $estampillado->setHash($hash);
            $estampillado->setQr($qr);
            $entityManager->persist($estampillado);
            $entityManager->flush();
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            $this->setStatusCode(500);
            return $this->respondWithErrors("El número de expediente ya ha sido estampillado");
        } catch (\Exception $e) {
            $this->setStatusCode(500);
            return $this->respondWithErrors($e->getMessage());
        }        

        return $this->respondCreated([
            "hash" => $estampillado->getHash()
        ]);
    }

    private function is_base64($s){
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
    
        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if(false === $decoded) return false;
    
        // Encode the string again
        if(base64_encode($decoded) != $s) return false;
    
        return true;
    }

    private function generateQr($url, $key = "622ba6892dmsh07d7bf795f1a476p1d5971jsnb43d3e4bada2"){
        $client = new Client([
            'base_uri' => 'https://neutrinoapi-qr-code.p.rapidapi.com'
        ]);       

        try {
            $response = $client->request('POST', 'qr-code', [
                'verify' => (($this->getParameter('kernel.environment') == "dev")? false : true ),
                'headers' => [
                    'content-type' => 'application/x-www-form-urlencoded',
                    'x-rapidapi-host' => 'neutrinoapi-qr-code.p.rapidapi.com',
                    'x-rapidapi-key' => $key
                ],
                'form_params' => [
                    "content" => $url,
                    "width" => "256",
                    "height" => "256",
                    "fg-color" => "#000000",
                    "bg-color" => "#ffffff"
                ]
            ]);
        } catch (\Exception $e) {
            return $this->generateQr($url,"4fc11a3da3mshe830a408f668c5ap1439f7jsn1d0514b93f1d");
        }

        return (string) $response->getBody();
    }
}
