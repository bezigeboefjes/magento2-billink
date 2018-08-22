<?php

namespace Balticode\Billink\Gateway\Helper;

use Balticode\Billink\Gateway\Converter\Order\ConverterInterface;
use Balticode\Billink\Gateway\Request\OrderItemsDataBuilder;

/**
 * Class Calculator
 * @package Balticode\Billink\Gateway\Helper
 */
class Calculator
{
    /**
     * @var ConverterInterface
     */
    private $orderItemsConverter;

    /**
     * Calculator constructor.
     * @param ConverterInterface $orderItemsConverter
     */
    public function __construct(
        ConverterInterface $orderItemsConverter
    ) {
        $this->orderItemsConverter = $orderItemsConverter;
    }

    /**
     * @param \Magento\Quote\Model\Quote $orderData
     * @return float|int
     */
    public function calculateOrderTotal($orderData)
    {
        $total = 0;

        $items = $this->orderItemsConverter->convert($orderData);

        foreach ($items as $item) {
            if ($item->getPriceType() === OrderItemsDataBuilder::PRICEINCL) {
                $price = $item->getPrice();
            } else {
                $price = $item->getPrice() + ($item->getPrice() / 100 * $item->getTaxPercent());
            }

            $total += round($item->getQuantity() * $price, 2);
        }

        return $total;
    }
}