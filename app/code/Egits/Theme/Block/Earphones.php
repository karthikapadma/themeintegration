<?php

namespace Egits\Theme\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\UrlInterface;

class Earphones extends Template
{
    protected $productCollectionFactory;
    protected $productFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        ProductFactory $productFactory,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }

    public function getImageUrl($productImage)
    {
        // Get the base media URL using BaseUrlResolver
        $baseMediaUrl = $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);

        // Combine the base media URL with the image path
        $imageUrl = $baseMediaUrl . 'catalog/product' . $productImage;
        return $imageUrl;
    }

    public function getAllProducts()
    {
        $categoryId = 26; // Category ID for mens shoes
        $products = $this->productCollectionFactory
            ->create()
            ->addCategoriesFilter(['in' => $categoryId]);
        $productDetails = [];

        foreach ($products as $product) {
            $productId = $product->getId();
            $productDetail = $this->productFactory->create()->load($productId);

            $productName = $productDetail->getName();
        
            $productImage = $productDetail->getImage();
            $productprice = $productDetail->getPrice();
            $productImageUrl = $this->getImageUrl($productImage);
            $productUrl = $productDetail->getUrlKey();

            // Check if the product is a configurable product
            if ($productDetail->getTypeId() == 'configurable') {
                // Pass the configurable product ID to getSimpleProductsForConfigurable
                $simpleProducts = $this->getSimpleProductsForConfigurable($productId);

                $productDetails[] = [
                    'id' => $productId,
                    'name' => $productName,
                    'image' => $productImageUrl,
                    'url' => $productUrl,
                    'price' => $productprice,
                    'simple_products' => $simpleProducts,
                ];
            }
        }
        return $productDetails;
    }

    public function getSimpleProductsForConfigurable($configurableProductId)
    {
        $configurableProduct = $this->productFactory->create()->load($configurableProductId);
        $simpleProducts = [];

        // Check if the loaded product is a configurable product
        if ($configurableProduct->getTypeId() != 'configurable') {
            return $simpleProducts; // Return an empty array if the provided ID is not for a configurable product
        }

        // Get the associated simple products
        $associatedProducts = $configurableProduct->getTypeInstance()->getUsedProducts($configurableProduct);

        foreach ($associatedProducts as $simpleProduct) {
            $simpleProductId = $simpleProduct->getId();
            $simpleProductColor =  $simpleProduct->getAttributeText('color'); // Get the color of the simple product.
            $simpleProducts[] = [
                'id' => $simpleProductId,
                'color' => $simpleProductColor,
            ];
        }

        return $simpleProducts;
    }
}