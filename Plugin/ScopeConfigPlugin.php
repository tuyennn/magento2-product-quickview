<?php

namespace GhoSter\Quickview\Plugin;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class ScopeConfigPlugin handle configuration
 */
class ScopeConfigPlugin
{
    /** @var HttpRequest */
    protected $request;

    /**
     * ResultPage constructor.
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param ScopeConfigInterface $subject
     * @param \Closure $proceed
     * @param $path
     * @param $scopeType
     * @param null $scopeCode
     * @return string
     */
    public function aroundGetValue(
        ScopeConfigInterface $subject,
        \Closure $proceed,
        $path,
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ) {
        $result = $proceed($path, $scopeType, $scopeCode);

        if (($path == 'checkout/cart/redirect_to_cart')) {
            $refererUrl = $this->request->getServer('HTTP_REFERER');
            if (strpos($refererUrl, 'ghoster_quickview/catalog_product/view') !== false) {
                return false;
            }
        }

        return $result;
    }
}
