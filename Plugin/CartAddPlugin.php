<?php

namespace GhoSter\Quickview\Plugin;

use Magento\Checkout\Controller\Cart\Add;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 * Class CartAddPlugin handle the add to cart action
 */
class CartAddPlugin
{
    /** @var HttpRequest */
    protected $request;

    /** @var EncoderInterface */
    protected $jsonEncoder;

    /**
     * ResultPage constructor.
     * @param HttpRequest $request
     * @param EncoderInterface $jsonEncoder
     */
    public function __construct(
        HttpRequest $request,
        EncoderInterface $jsonEncoder
    ) {
        $this->request = $request;
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * @param Add $subject
     * @param $result
     * @return mixed
     */
    public function afterExecute(
        Add $subject,
        $result
    ) {

        $refererUrl = $this->request->getServer('HTTP_REFERER');

        if (strpos($refererUrl, 'ghoster_quickview/catalog_product/view') !== false) {
            return $subject->getResponse()->representJson($this->jsonEncoder->encode([]));
        }
        return $result;
    }
}
