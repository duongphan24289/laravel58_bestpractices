<?php

return [

    /**
     * Is email activation required
     */
    'activation' => env('ACTIVATION', false),

    /**
     * max time for activation
     */
    'maxAttempts' => env('ACTIVATION_LIMIT_MAX_ATTEMPTS', 3),

    /*
     * Period time activation
     */
    'timePeriod' => env('ACTIVATION_LIMIT_TIME_PERIOD', 24)

];