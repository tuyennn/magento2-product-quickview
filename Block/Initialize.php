<?php

namespace GhoSter\Quickview\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use GhoSter\Quickview\Model\Config as QuickViewConfig;
use Magento\Framework\View\Element\Template;

/**
 * Class Initialize block init the js
 */
class Initialize extends Template
{
    /** @var QuickViewConfig */
    protected $config;

    /**
     * @param QuickViewConfig $config
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        QuickViewConfig $config,
        Context $context,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getConfig()
    {
        return [
            'baseUrl' => $this->_storeManager->getStore()->getBaseUrl()
        ];
    }
}
