<?php

namespace Balticode\Billink\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class BillinkError
 * @package Balticode\Billink\Logger\Handler
 */
class BillinkError extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/billink.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::ERROR;
}