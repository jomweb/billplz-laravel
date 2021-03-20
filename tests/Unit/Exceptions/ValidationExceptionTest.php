<?php

namespace Billplz\Laravel\Tests\Unit\Exceptions;

use Billplz\Laravel\Exceptions\ValidationException;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ValidationExceptionTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_has_proper_signature()
    {
        $validator = m::mock('Illuminate\Contracts\Validation\Validator');
        $response = m::mock('Symfony\Component\HttpFoundation\Response');

        $validator->shouldReceive('errors->messages')->andReturn([
            'device_id' => 'The device_id is required.',
        ]);

        $e = new ValidationException($validator, $response);

        $this->assertSame($response, $e->getResponse());
        $this->assertSame($response, $e->response);
        $this->assertSame($validator, $e->validator);
        $this->assertSame('default', $e->errorBag);
        $this->assertSame(422, $e->getStatusCode());
        $this->assertSame('The given data was invalid.', $e->getMessage());
        $this->assertSame(['device_id' => 'The device_id is required.'], $e->errors());
    }

    /** @test */
    public function it_can_override_error_bag()
    {
        $validator = m::mock('Illuminate\Contracts\Validation\Validator');
        $response = m::mock('Symfony\Component\HttpFoundation\Response');

        $e = new ValidationException($validator, $response);

        $e->errorBag('custom');

        $this->assertSame('custom', $e->errorBag);
    }

    /** @test */
    public function it_can_override_status_code()
    {
        $validator = m::mock('Illuminate\Contracts\Validation\Validator');
        $response = m::mock('Symfony\Component\HttpFoundation\Response');

        $e = new ValidationException($validator, $response);

        $e->status(401);

        $this->assertSame(401, $e->getStatusCode());
    }
}
