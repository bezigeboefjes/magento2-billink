<?php

namespace Balticode\Billink\Gateway\Helper;

use Balticode\Billink\Gateway\Exception\InvalidResponseException;

/**
 * Class ErrorMessage
 * @package Balticode\Billink\Gateway\Helper
 */
class ErrorMessage
{
    /**
     * @param string $code
     * @param string $service
     * @return \Magento\Framework\Phrase
     * @throws InvalidResponseException
     */
    public static function get($code, $service)
    {
        $messageId = 'billink_' . $service . '_error_code_' . $code;
        $message = __($messageId);

        if ($messageId == $message) {
            throw new InvalidResponseException(
                'Got error ' . $code . ' from ' . strtoupper($service) .
                ' service, no translation for this error is present'
            );
        }

        return $message;
    }
}