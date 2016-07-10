# api-response
> Helper class for giving JSON api response

## Motivation
Its hard to allways write api response for everyting, and this package will make the job much easier.

This package and its base concept is greatly inspired by [dingo/api](https://github.com/dingo/api).
And uses most of the same transformer syntax as [Fractal](http://fractal.thephpleague.com/transformers/).

## Install
I use this package mainly in my [Laravel](https://laravel.com/) projects.

Run ```composer require lassehaslev/api-response``` in your project folder

## Usage
#### Responder
The Responder is where we call what items we want transformed to JsonResponse. This class need to implement the ```ResponseTrait``` and will then make the ```$this->response``` object available. This will make it posible to use ```$response->item()``` and ```$response->collection()```.
The first argument for both functions are the data to be transformed, the second argument is the transformer to transform the data. Read below for more information.
``` php
use LasseHaslev\ApiResponse\Responses\ResponseTrait;
class ResponseCaller
{
    use ResponseTrait;

    public function getItem() {
        return $this->response->item( [ 'name'=>'Test name' ], new Transformer );
    }

    public function getCollection() {
        return $this->response->collection( [
            [ 'name'=>'Test name' ],
            [ 'name'=>'Another test name' ]
        ], new Transformer );
    }

}
```

#### Transformer
The transformer is where we format the data to the api.
All you have to do is to create a ```public function transform``` with the model you want to transformed.
Then you return an ```array``` with the data.

You can also have the transformer include more data. This can be useful when model has data. 
This is done by two different types ```default``` and ```available```, but both types works the same way:
Update the array of the type example: ```protected $defaultIncludes = ['name']```.
Then you need to create a public function thats has name prefix ```include```. Example: ```public function includeName( $model )```.

###### Default includes
The default include will be included by default.

###### Available includes
The available include will only be included when url parameter ```include``` are provided. Example ```/api/request?include=name```

If you have multiple available includes you can include them by having url request like ```/api/request?include=first,second```

``` php
use LasseHaslev\ApiResponse\Transformers\Transformer as BaseTransformer;
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
        return [
            'name'=>$model[ 'name' ],
        ];
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
```

## License
MIT, dawg
