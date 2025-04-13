<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 *
 */
class DoesNotAllowCancellationOrder extends Exception
{
    /**
     * @var string
     */
    protected $message = "It is not allowed to cancel an order that has already been approved.";
}
