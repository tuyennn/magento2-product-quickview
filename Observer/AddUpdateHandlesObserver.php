<?php

namespace GhoSter\Quickview\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\Observer;

/**
 * Class AddUpdateHandlesObserver add handles types
 */
class AddUpdateHandlesObserver implements ObserverInterface
{
    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /** @var HttpRequest */
    protected $request;

    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /**
     * AddUpdateHandlesObserver constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param HttpRequest $request
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        HttpRequest $request,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Observer $observer
     * @return $this|bool|void
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getData('layout');
        $fullActionName = $observer->getData('full_action_name');

        if ($fullActionName != 'ghoster_quickview_catalog_product_view') {
            return $this;
        }

        $productId = $this->request->getParam('id');
        $storeId = $this->storeManager->getStore()->getId();

        if ($productId) {
            try {
                $product = $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return $this;
            }

            $layout->getUpdate()->addHandle('ghoster_quickview_catalog_product_view_type_' . $product->getTypeId());

        }

        return $this;
    }
}
