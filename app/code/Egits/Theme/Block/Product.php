<?php

namespace Egits\Theme\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Eav\Model\Entity\AttributeFactory;
use Magento\Eav\Model\Entity\Attribute\Source\Table;


class Product extends Template
{
    protected $formKey;
    protected $productCollectionFactory;
    protected $productFactory;
    protected $attributeFactory;


    public function __construct(
        Context $context,
        FormKey $formKey,
        CollectionFactory $productCollectionFactory,
        ProductFactory $productFactory,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }
    public function addProductToWishlist($productId)
    {
        $formKey = $this->formKey->getFormKey();

    }

    public function getImageUrl($productImage)
    {
        // Get the base media URL using BaseUrlResolver
        $baseMediaUrl = $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);

        // Combine the base media URL with the image path
        $imageUrl = $baseMediaUrl . 'catalog/product' . $productImage;
        return $imageUrl;
    }

    // public function getAllProducts()
    // {
    //     $categoryId = 28; // Category ID for mens shoes
    //     $products = $this->productCollectionFactory
    //         ->create()
    //         ->addCategoriesFilter(['in' => $categoryId]);
    //     $productDetails = [];

    //     foreach ($products as $product) {
    //         $productId = $product->getId();
    //         $productDetail = $this->productFactory->create()->load($productId);

    //         $productName = $productDetail->getName();
    //         $productImage = $productDetail->getImage();
    //         $productprice = $productDetail->getPrice();

    //         // Use getImageUrl method to get the image URL
    //         $productImageUrl = $this->getImageUrl($productImage);
    //         $productUrl = $productDetail->getUrlKey();

    //         if ($productDetail->getTypeId() == 'configurable') {
    //             $productDetails[] = [
    //                 'id' => $productId,
    //                 'name' => $productName,
    //                 'image' => $productImageUrl,
    //                 'url' => $productUrl,
    //                 'price' => $productprice
    //             ];
    //             $configurableProductId = $product->getId();
    //             $configurableProduct = $this->productFactory->create()->load($configurableProductId);
    //             $simpleProducts = [];
    //             $associatedProducts = $configurableProduct->getTypeInstance()->getUsedProducts($configurableProduct);
    //             foreach ($associatedProducts as $simpleProduct) {
    //                 $simpleProductId = $simpleProduct->getId();
    //                 $simpleProductColorId = $simpleProduct['color'];
    //                 $simpleProductColorLabel = $simpleProductColorId;  // Replace 'color' with the actual attribute code for color
    //                 $simpleProducts[] = [
    //                     'id' => $simpleProductId,
    //                     'color' => $simpleProductColorLabel,
    //                 ];
    //             }
    //             var_dump($simpleProducts);exit;

    //             return $simpleProducts;
    //         }
    //     }
    //     return $productDetails;
    // }

    // public function getSimpleProductsForConfigurable($configurableProductId)
    // {
    //     $configurableProduct = $this->productFactory->create()->load($configurableProductId);

    //     // Check if the loaded product is a configurable product
    //     if ($configurableProduct->getTypeId() != 'configurable') {
    //         return []; // Return an empty array if the provided ID is not for a configurable product
    //     }

    //     $simpleProducts = [];

    //     // Get the associated simple products
    //     $associatedProducts = $configurableProduct->getTypeInstance()->getUsedProducts($configurableProduct);

    //     foreach ($associatedProducts as $simpleProduct) {
    //         $simpleProductId = $simpleProduct->getId();
    //         $simpleProductColor = $simpleProduct->getColor(); // Replace 'color' with the actual attribute code for color

    //         $simpleProducts[] = [
    //             'id' => $simpleProductId,
    //             'color' => $simpleProductColor,
    //         ];
    //     }

    //     return $simpleProducts;
    // }
    public function getAllProducts()
    {
        $categoryId = 28; // Category ID for mens shoes
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
            $simpleProductColor =  $simpleProduct->getAttributeText('color');// Get the color of the simple product.
            $simpleProducts[] = [
                'id' => $simpleProductId,
                'color' => $simpleProductColor,
            ];
        }

        return $simpleProducts;
    }

    }