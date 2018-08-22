<?php

namespace Balticode\Billink\Gateway\Http;

use Balticode\Billink\Gateway\Helper\Gateway as GatewayHelper;
use Balticode\Billink\Gateway\Helper\Xml as XmlHelper;
use Balticode\Billink\Gateway\Request\ActionDataBuilder;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;

class TransferFactory implements TransferFactoryInterface
{
    const XML_ROOT = 'API';

    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * @var Xml
     */
    private $xmlHelper;

    /**
     * @var Gateway
     */
    private $gatewayHelper;

    /**
     * TransferFactory constructor.
     * @param TransferBuilder $transferBuilder
     * @param XmlHelper $xmlHelper
     * @param GatewayHelper $gatewayHelper
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        XmlHelper $xmlHelper,
        GatewayHelper $gatewayHelper
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->xmlHelper = $xmlHelper;
        $this->gatewayHelper = $gatewayHelper;
    }

    /**
     * Builds gateway transfer object
     *
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request)
    {
        $service = $request[ActionDataBuilder::SERVICE];
        unset($request[ActionDataBuilder::SERVICE]);

        $body = $this->xmlHelper->convert($request, self::XML_ROOT);

        return $this->transferBuilder
            ->setHeaders(['Content-Type' => 'text/xml'])
            ->setBody($body)
            ->setUri($this->gatewayHelper->getUrl($service))
            ->setMethod(\Zend_Http_Client::POST)
            ->build();
    }
}