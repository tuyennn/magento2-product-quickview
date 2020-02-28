<?php

namespace GhoSter\Quickview\Block;

use GhoSter\Quickview\Model\Config;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class QuickViewButton for rendering the button
 */
class QuickViewButton extends Template implements IdentityInterface
{
    /**
     * Cache tag prefix
     */
    const CACHE_TAG = 'ghoster_quickview';

    /** @var string */
    protected $_template = 'GhoSter_Quickview::button.phtml';

    /** @var Product */
    private $product;

    /** @var HttpContext */
    private $httpContext;

    /** @var EncoderInterface */
    private $jsonEncoder;

    /** @var Config */
    protected $quickViewConfig;

    /** @var int */
    private $storeId;

    /** @var int */
    private $themeId;

    /**
     * QuickViewButton constructor.
     * @param Context $context
     * @param HttpContext $httpContext
     * @param EncoderInterface $jsonEncoder
     * @param Config $quickViewConfig
     * @param array $data
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Context $context,
        HttpContext $httpContext,
        EncoderInterface $jsonEncoder,
        Config $quickViewConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->httpContext = $httpContext;
        $this->jsonEncoder = $jsonEncoder;
        $this->quickViewConfig = $quickViewConfig;
        $this->product = $data['product'] ?? null;
        $this->storeId = $this->_storeManager->getStore()->getId();
        $this->themeId = $this->_design->getDesignTheme()->getId();
        $this->addData([
            'cache_lifetime' => 86400
        ]);
    }

    /**
     * @return string
     */
    public function getJsonConfig()
    {
        $productId = $this->getProduct()->getId();

        return $this->jsonEncoder->encode(
            [
                'position' => 'top-center',
                'path' => $this->getContainerPath(),
                'closeSeconds' => 5,
                'mode' => 'cat',
                'product' => $productId,
                'margin' => 10,
                'alignment' => 0
            ]
        );
    }

    /**
     * @return boolean|int
     */
    public function isAdminArea()
    {
        return $this->getArea() == 'adminhtml';
    }

    /**
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $productId = $this->getProduct()->getId();

        return [
            'GHOSTER_PRODUCT_QUICK_VIEW',
            $this->storeId,
            $this->themeId,
            $this->httpContext->getValue(CustomerContext::CONTEXT_GROUP),
            'template' => $this->getTemplate(),
            $productId
        ];
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return array_merge(
            ($this->getProduct() instanceof IdentityInterface) ? $this->getProduct()->getIdentities() : [],
            [self::CACHE_TAG . '_' . $this->getProduct()->getId()]
        );
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getContainerPath()
    {
        return $this->quickViewConfig->getContainerPath();
    }
}
