<?php

namespace LasseHaslev\ApiResponse\Responses;

/**
 * Class ResponsesTrait
 * @author Lasse S. Haslev
 */
trait ResponsesTrait
{

    /**
     * Reponse with no content
     *
     * @return response
     */
    public function noContent()
    {
        return $this->respond( null, 204 );
    }

    /**
     * Respond without a comment or respond with data
     *
     * @return response
     */
    public function created( $item = null, $transformer, $status = 201 )
    {
        if ( !$item || $transformer ) return $this->respond( null, $status );
        return $this->item( $item, $transformer, $status );
    }

    /**
     * Error with message
     *
     * @return response
     */
    public function error( $message, $status = 404 )
    {
        return $this->respond( [ 'message'=>$message ], $status );
    }
    public function errorNotFound($message = 'Error: Not found.', $status = 404)
    {
        return $this->error( $message, $status );
    }
    public function errorBadRequest( $message = 'Error: Bad request.', $status = 400 )
    {
        return $this->error( $message, $status );
    }
    public function errorForbidden( $message = 'Error: Forbidden.', $status = 403 )
    {
        return $this->error( $message, $status );
    }
    public function errorInternal( $message = 'Error: Internal.', $status = 500 )
    {
        return $this->error( $message, $status );
    }
    public function errorUnauthorized( $message = 'Error: Unauthorized', $status = 401 )
    {
        return $this->error( $message, $status );
    }
}
