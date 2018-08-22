<?php

namespace Balticode\Billink\Gateway\Validator\Check;

use Balticode\Billink\Gateway\Exception\InvalidResponseException;
use Balticode\Billink\Gateway\Helper\Gateway;
use Balticode\Billink\Gateway\Validator\AbstractResponseValidator;
use Balticode\Billink\Model\Billink\Response\Response;

/**
 * Class ResponseValidator
 * @package Balticode\Billink\Gateway\Validator\Check
 */
class ResponseValidator extends AbstractResponseValidator
{
    const RESULT_TRUSTED = 500;
    const RESULT_UNTRUSTED = 501;

    /**
     * @var string
     */
    protected $service = Gateway::SERVICE_CHECK;

    /**
     * @return array
     */
    public function getResponseValidators()
    {
        return array_merge(
            parent::getResponseValidators(),
            [
                function ($response) {
                    switch ($response->getMsg(Response::INDEX_MSG_CODE)) {
                        case self::RESULT_TRUSTED:
                            return ['result' => true];
                        case self::RESULT_UNTRUSTED:
                            return ['result' => false, 'code' => self::RESULT_UNTRUSTED];
                        default:
                            throw new InvalidResponseException('Unknown response code');
                    }
                }
            ]
        );
    }
}