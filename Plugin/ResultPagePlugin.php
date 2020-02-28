<?php

namespace GhoSter\Quickview\Plugin;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\View\Layout;
use Magento\Framework\View\Result\Page;

/**
 * Class ResultPagePlugin adding the default catalog_product_view
 */
class ResultPagePlugin
{
    /** @var HttpRequest */
    protected $request;

    /** @var Layout */
    protected $layout;

    /**
     * ResultPage constructor.
     * @param HttpRequest $request
     * @param Layout $layout
     */
    public function __construct(
        HttpRequest $request,
        Layout $layout
    ) {
        $this->request = $request;
        $this->layout = $layout;
    }

    /**
     * Adding the default catalog_product_view well
     *
     * @param Page $subject
     * @param array $parameters
     * @param $defaultHandle
     * @return array
     */
    public function beforeAddPageLayoutHandles(
        Page $subject,
        array $parameters = [],
        $defaultHandle = null
    ) {
        if ($this->request->getFullActionName() == 'ghoster_quickview_catalog_product_view') {
            return [$parameters, 'catalog_product_view'];
        }

        return [$parameters, $defaultHandle];
    }
}
