<?php

namespace GhoSter\Quickview\Plugin\Catalog\Product;

use Magento\Framework\Registry;
use GhoSter\Quickview\Model\Renderer;

/**
 * Class ListProductPlugin append html to list
 */
class ListProductPlugin
{
    /** @var Registry */
    private $registry;

    /** @var Renderer */
    private $renderer;

    /**
     * ListProduct constructor.
     * @param Registry $registry
     * @param Renderer $renderer
     */
    public function __construct(
        Registry $registry,
        Renderer $renderer
    ) {
        $this->registry = $registry;
        $this->renderer = $renderer;
    }

    /**
     * @param  $subject
     * @param $result
     * @return string
     */
    public function afterToHtml(
        $subject,
        $result
    ) {
        if (!$this->registry->registry('ghoster_category_observer')
            && !$subject->getIsGhoSterQuickViewObserved()
        ) {
            $products = $subject->getLoadedProductCollection();
            if (!$products) {
                $products = $subject->getProductCollection();
            }

            if ($products) {
                foreach ($products as $product) {
                    $result .= $this->renderer->renderProductQuickViewButton($product, 'category');
                }
                $subject->setIsGhoSterQuickViewObserved(true);
            }
        }

        return $result;
    }
}
