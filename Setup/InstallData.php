<?php

namespace Balticode\Billink\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;

/**
 * Class InstallData
 * @package Balticode\Billink\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var SalesSetupFactory
     */
    protected $salesSetupFactory;

    /**
     * @var QuoteSetupFactory
     */
    protected $quoteSetupFactory;

    /**
     * InstallData constructor.
     * @param SalesSetupFactory $salesSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    protected function _setupSalesTables(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $attributes = [
            'billink_fee_amount' => 'Billink Fee Amount',
            'base_billink_fee_amount' => 'Billink Fee Base Amount',
            'billink_fee_amount_tax' => 'Billink Fee Base Amount Tax',
            'base_billink_fee_amount_tax' => 'Billink Fee Base Amount Tax'
        ];

        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $salesSetup->addAttribute('order', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('order_address', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('invoice', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('creditmemo', $attributeCode, ['type' => 'decimal']);
        }

        $quoteSetup = $this->quoteSetupFactory->create(['setup' => $setup]);
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $quoteSetup->addAttribute('quote', $attributeCode, ['type' => 'decimal']);
            $quoteSetup->addAttribute('quote_address', $attributeCode, ['type' => 'decimal']);
        }
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->_setupSalesTables($setup, $context);
        $setup->endSetup();
    }
}