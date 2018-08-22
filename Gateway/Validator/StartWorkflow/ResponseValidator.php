<?php

namespace Balticode\Billink\Gateway\Validator\StartWorkflow;

use Balticode\Billink\Gateway\Exception\InvalidResponseException;
use Balticode\Billink\Gateway\Helper\Gateway;
use Balticode\Billink\Gateway\Validator\AbstractResponseValidator;
use Balticode\Billink\Model\Billink\Response\Response;

/**
 * Class ResponseValidator
 * @package Balticode\Billink\Gateway\Validator\StartWorkflow
 */
class ResponseValidator extends AbstractResponseValidator
{
    /**
     * @var string
     */
    protected $service = Gateway::SERVICE_START_WORKFLOW;

    const RESULT_SUCCESS = 500;

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
                        case self::RESULT_SUCCESS:
                            return ['result' => true];
                        default:
                            throw new InvalidResponseException('Invalid StartWorkflow result');
                    }
                }
            ]
        );
    }
}