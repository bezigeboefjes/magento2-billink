<?php

namespace Balticode\Billink\Gateway\Response\Order;

use Balticode\Billink\Gateway\Config\Config;
use Balticode\Billink\Gateway\Helper\SubjectReader;
use Balticode\Billink\Gateway\Validator\OrderDataValidator;
use Magento\Payment\Gateway\Response\HandlerInterface;

/**
 * Class Handler
 * @package Balticode\Billink\Gateway\Response\Order
 */
class Handler implements HandlerInterface
{
    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var Config
     */
    private $config;

    /**
     * Handler constructor.
     * @param SubjectReader $subjectReader
     * @param Config $config
     */
    public function __construct(
        SubjectReader $subjectReader,
        Config $config
    ) {

        $this->subjectReader = $subjectReader;
        $this->config = $config;
    }

    /**
     * Handles response
     *
     * @param array $handlingSubject
     * @param array $response
     * @return void
     */
    public function handle(array $handlingSubject, array $response)
    {
        if (isset($handlingSubject[OrderDataValidator::INDEX_FLAG_VALIDATION])) {
            return;
        }

        /** @var \Magento\Sales\Model\Order $order */
        $order = $this->subjectReader->readOrder($handlingSubject);
        $order->addStatusHistoryComment('Order was created in Billink system.');
    }
}