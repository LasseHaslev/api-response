<?php

namespace LasseHaslev\ApiResponse\Responses;

use LasseHaslev\ApiResponse\Responses\Response;

/**
 * Trait Responder
 * @author Lasse S. Haslev
 */
trait ResponseTrait
{

    use ResponsesTrait;

    protected $respond;

    protected $response;

    /**
     * Get the response factory instance
     *
     * @return LasseHaslev\ApiResponse\Response\Factory
     */
    protected function response()
    {
        if ( $this->response ) {
            return $this->response;
        }
        $this->response = new Response;

        return $this->response;
    }


    public function __get( $key ) {

        $callable = [
            'response'
        ];

        if (in_array($key, $callable) && method_exists($this, $key)) {
            return $this->$key();
        }
        throw new ErrorException('Undefined property '.get_class($this).'::'.$key);

    }

}
