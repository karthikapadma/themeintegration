<?php
namespace Egits\Theme\Block;


use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\CategoryFactory;

class CategoryAttributeCheck extends Template
{
    protected $categoryCollectionFactory;
    protected $categoryFactory;

    public function __construct(
        Template\Context $context,
        CategoryCollectionFactory $categoryCollectionFactory,
        CategoryFactory $categoryFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryFactory = $categoryFactory;
       // $this->setTemplate('CustomTheme::html/slider.phtml');
    }

    /**
     * Get featured categories.
     *
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */ 

     public function getCategories()
     {
        
         
        $categories = $this->categoryCollectionFactory->create();
         
        foreach ($categories as $category) {
             $categoryId = $category->getId();
            //  $categoryDetail = $this->categoryFactory->create()->load($categoryId)
            //         ->addAttributeToSelect(['name', 'image'])
            //         ->addAttributeToFilter('custom_attribute2', 1)
            //         ->setPageSize(10);
            $categoryDetail = $this->categoryFactory->create()->load($categoryId);
            $customAttribute2Value = $categoryDetail->getData('custom_attribute2') ? $categoryDetail->getData('custom_attribute2') : null;
             if ($customAttribute2Value == 1) {
                $categoryName = $categoryDetail->getName();
                $categoryImage = $categoryDetail->getImage();
                $matchingCategories[] = [
                    'id' => $categoryId,
                    'name' => $categoryName,
                    'image' => $categoryImage,
                ];
              
             }
         }
        return $matchingCategories;
     }
 }