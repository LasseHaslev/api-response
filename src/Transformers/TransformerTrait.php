<?php

namespace LasseHaslev\ApiResponse\Transformers;

use Illuminate\Http\Request;

/**
 * Class TransformerTrait
 * @author Lasse S. Haslev
 */
trait TransformerTrait
{

    /**
     * Set what is available includes
     */
    protected $availableIncludes = [];

    /*
     * Set what Icludes that should be included
     * by default
     */
    protected $defaultIncludes = [];

    /**
     * Respond with sigle item
     *
     * @return Response
     */
    public function item($model, $transformer = null)
    {

        // Prevent error if include dont work
        // This only returns null
        if ( ! $model ) {
            return $this->formatOutput(null);
        }

        // Check if we should call this function on another transformer
        if ( $transformer ) {
            return $transformer->item( $model );
        }

        // Format output to api
        return $this->formatOutput( $this->callTransform( $model ) );
    }

    /**
     * Respond with sigle item
     *
     * @return Response
     */
    public function collection( $collection, $transformer = null )
    {

        // Prevent error if include dont work
        // This only returns null
        if ( ! $collection ) {
            return $this->formatOutput([]);
        }

        // Check if we should call this function on another transformer
        if ( $transformer ) {
            return $transformer->collection( $collection );
        }

        // Build an data array to return
        $returnArray = [];
        foreach ($collection as $item) {
            $returnArray[] = $this->callTransform( $item );
        }

        // Format output
        return $this->formatOutput( $returnArray );
    }

    /**
     * Format output to api
     *
     * @return Array
     */
    protected function formatOutput($data)
    {
        return [ 'data'=>$data ];
    }


    /**
     * This is the master function of transform
     * Check if we should include other includes functions
     * before calling $this->transform
     *
     * @return Array
     */
    protected function callTransform($model)
    {

        // Use normal Transformer
        $returnData = $this->transform( $model );

        // Include default includes
        $returnData = $this->includeDefaultIncludes( $model, $returnData );

        // Include available includes
        $returnData = $this->includeAvailableIncludes( $model, $returnData );

        return $returnData;
    }

    /**
     * Include default includes
     *
     * @return Array
     */
    protected function includeDefaultIncludes($model, $data)
    {
        // Create an return array
        $returnData = [];

        // If we have default includes
        if ( ! empty( $this->defaultIncludes ) ) {

            // Loop through all includes
            foreach ($this->defaultIncludes as $include) {

                // Add the new data
                $returnData[ $include ] = $this->includeByName( $include, $model );

            }

        }

        // Return data
        return array_merge( $data, $returnData );
    }

    /**
     * Include available includes
     *
     * @return Array
     */
    protected function includeAvailableIncludes($model, $data )
    {

        // Get available includes from url parameters
        $includes = $this->getAvailableIncludesFromUrlParameters();

        // Create an return array
        $returnData = [];

        // Check if we have includes and include parameter values
        if ( ! empty( $includes ) && ! empty( $this->availableIncludes ) ) {

            // Loop through all includes
            foreach ($this->availableIncludes as $include) {

                // If the words exists in both includes
                if ( in_array( $include, $includes ) ) {

                    // Add the new data
                    $returnData[ $include ] = $this->includeByName( $include, $model );

                }
            }
        }

        // Return data
        return array_merge( $data, $returnData );
    }

    /**
     * Call the include function thats equal to the name
     *
     * @return Array
     */
    protected function includeByName( $name, $model )
    {

        $functionName = sprintf( 'include%s', ucfirst( $name ) );

        if ( ! method_exists( static::class, $functionName ) ) {
            throw new \Exception(sprintf( 'The function name "%s" does not exists on %s', $functionName, static::class ));
        }

        return $this->{$functionName}( $model );

    }

    /**
     * Get available includes from url parameters
     *
     * @return Array
     */
    protected function getAvailableIncludesFromUrlParameters()
    {
        return isset( $_GET[ 'include' ] ) ? explode( ',', $_GET[ 'include' ] ) : [];
    }

}
