<?php

namespace Balticode\Billink\Block\Adminhtml\System\Config\Form\Field\FeeRange;

use Balticode\Billink\Gateway\Helper\Workflow;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Html\Select;

/**
 * Class WorkflowType
 * @package Balticode\Billink\Block\Adminhtml\System\Config\Form\Field\FeeRange
 */
class WorkflowType extends Select
{
    /**
     * @var Workflow
     */
    private $workflowHelper;

    /**
     * WorkflowType constructor.
     * @param Context $context
     * @param Workflow $workflowHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Workflow $workflowHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->workflowHelper = $workflowHelper;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $types = $this->workflowHelper->getTypes();

        if (!$this->getOptions()) {
            foreach ($types as $type) {
                $key = $this->workflowHelper->getOptionKey($type['value']);

                $this->addOption($key, $type['label']);
            }
        }

        return parent::_toHtml();
    }

    /**
     * Set element name
     *
     * @param $value string
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}