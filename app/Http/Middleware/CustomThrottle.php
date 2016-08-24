<?php

namespace App\Http\Middleware;


use Illuminate\Container\Container;

use Dingo\Api\Http\RateLimit\Throttle\Throttle;

class CustomThrottle extends Throttle

{

    protected $enabled;

    public function __construct(array $options = ['limit' => 131, 'expires' => 60], $enabled = true)

    {

        $this->enabled = $enabled;
        parent::__construct($options);

    }

    public function match(Container $app)

    {
        return $this->enabled;

    }

}