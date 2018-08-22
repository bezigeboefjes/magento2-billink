<?php

namespace Balticode\Billink\Model\Ui;

use Balticode\Billink\Gateway\Config\Config;
use Balticode\Billink\Gateway\Helper\SubjectReader;
use Balticode\Billink\Gateway\Helper\Workflow as WorkflowHelper;
use Balticode\Billink\Observer\DataAssignObserver;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ConfigProvider
 * @package Balticode\Billink\Model\Ui
 */
final class ConfigProvider implements ConfigProviderInterface
{
    /**
     * Payment method code used in the system
     */
    const CODE = 'billink';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var SubjectReader
     */
    private $subjectReader;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ConfigProvider constructor.
     * @param Config $config
     * @param Session $checkoutSession
     * @param SubjectReader $subjectReader
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Config $config,
        Session $checkoutSession,
        SubjectReader $subjectReader,
        StoreManagerInterface $storeManager
    ) {
        $this->config = $config;
        $this->checkoutSession = $checkoutSession;
        $this->subjectReader = $subjectReader;
        $this->storeManager = $storeManager;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return array_merge([
            'payment' => $this->preparePaymentConfig(),
            'quoteData' => $this->prepareQuoteData()
        ]);
    }

    /**
     * @return array
     */
    private function preparePaymentConfig()
    {
        return [
            self::CODE => [
                'logo' => $this->config->getLogo($this->storeManager->getStore()),
                'isActive' => $this->config->isActive(),
                'isAlternateDeliveryAddressAllowed' => $this->config->getIsAlternateDeliveryAddressAllowed(),
                'workflow' => $this->config->getWorkflow(),
                'workflowTypePrefix' => WorkflowHelper::WORKFLOW_TYPE_PREFIX,
                'feeActive' => $this->config->getIsFeeActive(),
                'feeLabel' => $this->config->getFeeLabel()
            ]
        ];
    }

    /**
     * @return array
     */
    private function prepareQuoteData()
    {
        $quote = $this->checkoutSession->getQuote();

        if (!$quote || !($payment = $quote->getPayment())) {
            return [];
        }

        $selectedWorkflow = $this->subjectReader->readPaymentAIField(
            DataAssignObserver::CUSTOMER_TYPE,
            ['payment' => $payment]
        );

        return [
            'payment_method' => $payment->getMethod(),
            'selected_workflow' => $selectedWorkflow
        ];
    }
}