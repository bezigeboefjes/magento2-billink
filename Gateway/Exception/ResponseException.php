<?php

namespace Balticode\Billink\Gateway\Exception;

use Balticode\Billink\Gateway\Helper\ErrorMessage;

/**
 * Class ResponseException
 * @package Balticode\Billink\Gateway\Exception
 */
class ResponseException extends \Exception
{
    /**
     * ResponseException constructor.
     * @param int $code
     * @param string $service
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $service = 'general', \Exception $previous = null)
    {
        $message = ErrorMessage::get($code, $service);

        parent::__construct($message, $code, $previous);
    }
}