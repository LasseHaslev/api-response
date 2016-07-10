<?php

namespace LasseHaslev\ApiResponse\Responses;

/**
 * Trait Responder
 * @author Lasse S. Haslev
 */
trait ResponseTrait
{

    use ResponsesTrait;

    protected $respond;

    /**
     * Get the response factory instance
     *
     * @return LasseHaslev\ApiResponse\Response\Factory
     */
    protected function response()
    {
        return app( 'LasseHaslev\ApiResponse\Response\Response' );
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
