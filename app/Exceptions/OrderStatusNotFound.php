<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 *
 */
class OrderStatusNotFound extends Exception
{
    /**
     * @var string
     */
    protected $message = "Order status not found";
}
