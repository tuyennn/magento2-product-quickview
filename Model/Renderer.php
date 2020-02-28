<?php

namespace GhoSter\Quickview\Model;

use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Profiler;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Framework\View\LayoutInterface;
use GhoSter\Quickview\Block\QuickViewButton;

/**
 * Class Renderer for render button Quick View on list
 */
class Renderer
{
    const MODE_CATEGORY = 'category';

    /** @var LayoutInterface */
    private $layout;

    /** @var null|QuickViewButton */
    private $buttonBlock = null;

    /**
     * Renderer constructor.
     * @param LayoutInterface $layout
     */
    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * @param Product $product
     * @param string $mode
     * @return string
     */
    public function renderProductQuickViewButton(Product $product, $mode = self::MODE_CATEGORY)
    {
        $html = '';
        Profiler::start('__RenderGhoSterProductQuickViewButton__');
        $html .= $this->generateHtml($product);
        Profiler::stop('__RenderGhoSterProductQuickViewButton__');

        return $html;
    }

    private function generateHtml(Product $product)
    {
        if ($this->buttonBlock === null) {
            $this->buttonBlock = $this->layout->createBlock(QuickViewButton::class);
        }
        return $this->buttonBlock->setProduct($product)->toHtml();
    }
}
