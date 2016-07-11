<?php

use LasseHaslev\ApiResponse\Responses\ResponseTrait;
use LasseHaslev\ApiResponse\Transformers\BaseTransformer;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DontKnowTest
 * @author Lasse S. Haslev
 */
class TransformerTest extends PHPUnit_Framework_TestCase
{

    protected $responder;
    protected $testData;

    public function setUp() {
        $this->responder = new ResponseCaller;
        $this->testData = [
            'data'=>[
                'name'=>'data',
                'default'=>[ 'name'=>'Include default' ],
            ]
        ];
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

        // Modify data
        $this->testData[ 'data' ][ 'available' ] = [ 'name'=>'Include available' ];

        $response = $this->responder->response->item( [ 'name'=>'data' ], new Transformer );
        $this->assertJsonStringEqualsJsonString( json_encode( $this->testData ), $response->getContent() );

        $_GET[ 'include' ] = null;

    }

    public function test_get_collection() {

        $response = $this->responder->response->collection( [ [ 'name'=>'data' ], [ 'name'=>'data' ] ], new Transformer );
        $this->assertJsonStringEqualsJsonString( json_encode([
            'data'=>[
                $this->testData[ 'data' ],
                $this->testData[ 'data' ],
            ]
        ]), $response->getContent() );
    }

}


class ResponseCaller
{
    use ResponseTrait;
}

class Transformer extends BaseTransformer
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
