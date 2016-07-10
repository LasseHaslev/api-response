<?php

use LasseHaslev\ApiResponse\Transformers\TransformerTrait;
use LasseHaslev\ApiResponse\Responses\ResponseTrait;

/**
 * Class DontKnowTest
 * @author Lasse S. Haslev
 */
class TransformerTest extends PHPUnit_Framework_TestCase
{

    protected $test;

    public function setUp() {
        $this->test = new ResponseCaller;
    }

    /**
     * Transform returns array
     */
    public function test_transform_returns_array() {

        var_dump( $this->test->response->item( [ 'name'=>'data' ], new Transformer ) );

    }
    public function test_formats_array_output() {}
    public function test_include_includes_on_() {}
    public function test_include_default_includes() {}
    public function test_include_available_includes_when_get_include_parameter_is_set() {}

}


class ResponseCaller
{
    use ResponseTrait;
}

class Transformer
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
        return $model->attributes();
    }

}
