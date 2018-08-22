<?php

namespace Balticode\Billink\Block\Adminhtml\System\Config\Form\Field;

use Balticode\Billink\Block\Adminhtml\System\Config\Form\Field\FeeRange\WorkflowType;
use Balticode\Billink\Gateway\Helper\Workflow as WorkflowHelper;
use Balticode\Billink\Helper\Fee;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

/**
 * Class FeeRange
 * @package Balticode\Billink\Block\Adminhtml\System\Config\Form\Field
 */
class FeeRange extends AbstractFieldArray
{
    /**
     * @var Workflow
     */
    private $workflowHelper;

    /**
     * FeeRange constructor.
     *
     * @param Context $context
     * @param WorkflowHelper $workflowHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        WorkflowHelper $workflowHelper,
        array $data = []
    ) {
        $this->workflowHelper = $workflowHelper;

        parent::__construct($context, $data);
    }

    /**
     * @var WorkflowType
     */
    private $typeRenderer;

    /**
     * Add table system config columns
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(Fee::INDEX_WORKFLOW_TYPE, [
            'label' => __('Workflow Type'),
            'renderer' => $this->getWorkflowTypeRenderer()
        ]);

        $this->addColumn(Fee::INDEX_TOTAL_FROM, [
            'label' => __('From')
        ]);

        $this->addColumn(Fee::INDEX_TOTAL_TO, [
            'label' => __('To')
        ]);

        $this->addColumn(Fee::INDEX_AMOUNT, [
            'label' => __('Amount')
        ]);

        $this->_addAfter = false;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getWorkflowTypeRenderer()
    {
        if (!$this->typeRenderer) {
            $this->typeRenderer = $this->getLayout()->createBlock(
                WorkflowType::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->typeRenderer;
    }

    /**
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $workflowType = $row->getWorkflowType();

        if ($workflowType) {
            $optionType = $this->getWorkflowTypeRenderer()->calcOptionHash($workflowType);

            $options['option_' . $optionType] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }
}