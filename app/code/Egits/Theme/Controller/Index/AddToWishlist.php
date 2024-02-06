<?php

namespace Egits\Theme\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class AddToWishlist extends Action
{
    protected $productRepository;
    protected $wishlistProvider;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        WishlistProviderInterface $wishlistProvider,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->wishlistProvider = $wishlistProvider;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $productId = $this->getRequest()->getParam('product_id');

        try {
            $product = $this->productRepository->getById($productId);
            $wishlist = $this->wishlistProvider->getWishlist();
            $wishlist->addNewItem($product);
            $wishlist->save();

            $result = ['success' => true, 'message' => __('Product added to wishlist successfully.')];
        } catch (\Exception $e) {
            $result = ['success' => false, 'message' => $e->getMessage()];
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}
