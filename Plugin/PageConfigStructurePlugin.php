<?php

namespace GhoSter\Quickview\Plugin;

use Magento\Framework\View\Page\Config\Structure;
use GhoSter\Quickview\Model\Config as QuickViewConfig;

/**
 * Class PageConfigStructurePlugin remove asset depends configuration
 */
class PageConfigStructurePlugin
{

    /** @var QuickViewConfig */
    protected $config;

    /**
     * PageConfigStructurePlugin constructor.
     * @param QuickViewConfig $config
     */
    public function __construct(
        QuickViewConfig $config
    ) {
        $this->config = $config;
    }

    /**
     * @param Structure $subject
     * @param string $name
     * @param array $attributes
     * @return array
     */
    public function beforeAddAssets(
        Structure $subject,
        $name,
        $attributes
    ) {
        if (!$this->config->isEnabled()) {
            switch ($name) {
                case 'GhoSter_Quickview::css/magnific-popup.css':
                    $subject->removeAssets($name);
                    break;
            }
        }

        return [$name, $attributes];
    }
}
