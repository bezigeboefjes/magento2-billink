<?php

namespace Balticode\Billink\Model\Total;

/**
 * Trait AvailabilityTrait
 * @package Balticode\Billink\Model\Total
 */
trait AvailabilityTrait
{
    /**
     * @param \Magento\Sales\Model\Order|\Magento\Quote\Model\Quote $subject
     * @return bool
     */
    protected function isApplicable($subject)
    {
        if (!$this->config->getIsFeeActive()) {
            return false;
        }

        return ($subject->getPayment()->getMethod() == \Balticode\Billink\Model\Ui\ConfigProvider::CODE);
    }
}