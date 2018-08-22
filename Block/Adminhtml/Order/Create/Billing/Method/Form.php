<?php

namespace Balticode\Billink\Block\Adminhtml\Order\Create\Billing\Method;

use Magento\Framework\View\Element\Template;

class Form extends \Magento\Payment\Block\Form
{
    /**
     * @var \Balticode\Billink\Gateway\Helper\Workflow
     */
    private $workflowHelper;

    public function __construct(
        Template\Context $context,
        \Balticode\Billink\Gateway\Helper\Workflow $workflowHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->workflowHelper = $workflowHelper;
    }


    public function getCustomerTypes()
    {
        return $this->workflowHelper->getTypes();
    }
}