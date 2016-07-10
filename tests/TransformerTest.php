<?php

use LasseHaslev\ApiResponse\Responses\ResponseTrait;
use LasseHaslev\ApiResponse\Transformers\Transformer as TransformerBase;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DontKnowTest
 * @author Lasse S. Haslev
 */
class TransformerTest extends PHPUnit_Framework_TestCase
{



    protected $responder;

    public function setUp() {
        $this->responder = new ResponseCaller;
    }

    /**
     * Transform return JsonResponse
     */
    public function test_transform_returns_json_response() {

        $response = $this->responder->response->item( [ 'name'=>'data' ], new Transformer );
        $this->assertInstanceOf( JsonResponse::class, $response );

    }

    public function test_include_default_includes() {
        $response = $this->responder->response->item( [ 'name'=>'data' ], new Transformer );
        $this->assertJsonStringEqualsJsonString( json_encode([
            'data'=>[
                'name'=>'data',
                'default'=>[ 'name'=>'Include default' ],
            ]
        ]), $response->getContent() );
    }
    public function test_include_available_includes_when_get_include_parameter_is_set() {

        $_GET[ 'include' ] = 'available';

        $response = $this->responder->response->item( [ 'name'=>'data' ], new Transformer );
        var_dump( $response );
        $this->assertJsonStringEqualsJsonString( json_encode([
            'data'=>[
                'name'=>'data',
                'default'=>[ 'name'=>'Include default' ],
                'available'=>[ 'name'=>'Include available' ],
            ]
        ]), $response->getContent() );

    }

}


class ResponseCaller
{
    use ResponseTrait;
}

class Transformer extends TransformerBase
{

    protected $defaultIncludes = [ 'default' ];
    protected $availableIncludes = [ 'available' ];

    /**
     * Transform $model
     *
     * @return Array
     */
    public function transform( $model )
    {
        return $model;
    }

    /**
     * Return include default
     *
     * @return Array
     */
    public function includeDefault($model)
    {
        return [ 'name'=>'Include default' ];
    }

    /**
     * Return include available
     *
     * @return Array
     */
    public function includeAvailable($model)
    {
        return [ 'name'=>'Include available' ];
    }

}
