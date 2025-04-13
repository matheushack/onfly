<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Allows cancellation approved order
    |--------------------------------------------------------------------------
    |
    | Determines whether it is allowed to cancel an already approved order.
    |
    */
    'allows_cancellation_approved_order' => env('ONFLY_CANCELLATION_APPROVED_ORDER', true),
];