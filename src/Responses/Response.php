<?php

namespace LasseHaslev\ApiResponse\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Responder
 * @author Lasse S. Haslev
 */
class Response
{

    use ResponseTrait;

    /**
     * Respond with sigle item
     *
     * @return Response
     */
    public function item($model, $transformer, int $status = 200)
    {
        $data = $transformer->item( $model );
        return $this->respond( $data, $status );
    }

    /**
     * Respond with sigle item
     *
     * @return Response
     */
    public function collection( $collection, $transformer, int $status = 200 )
    {
        $data = $transformer->collection( $collection );
        return $this->respond( $data, $status, $status );
    }


    /**
     * Respond with JsonResponse
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function respond( $data, int $status = 200 )
    {
        return JsonResponse::create( $data, $status );
    }



}

