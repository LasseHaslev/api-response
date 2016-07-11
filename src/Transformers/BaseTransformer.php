<?php

namespace LasseHaslev\ApiResponse\Transformers;

/**
 * Class Transformer
 * @author Lasse S. Haslev
 */
class BaseTransformer
{

    use TransformerTrait;

    /**
     * Transform $model
     *
     * @return Array
     */
    public function transform( $model )
    {
        return $model;
    }


}
