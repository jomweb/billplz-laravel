<?php

namespace Billplz\Laravel\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    /**
     * The validator instance.
     *
     * @var \Illuminate\Contracts\Validation\Validator
     */
    public $validator;

    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    public $response;

    /**
     * The name of the error bag.
     *
     * @var string
     */
    public $errorBag;

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    private $statusCode = 422;

    /**
     * Create a new exception instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  string  $errorBag
     *
     * @return void
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct(422, 'The given data was invalid.');

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors()->messages();
    }

    /**
     * Set the HTTP status code to be used for the response.
     *
     * @param  int  $statusCode
     *
     * @return $this
     */
    public function status($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Set the error bag on the exception.
     *
     * @param  string  $errorBag
     *
     * @return $this
     */
    public function errorBag($errorBag)
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the response status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
