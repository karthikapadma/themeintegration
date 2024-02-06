<?php

namespace Egits\BrandsList\Block;

use Magento\Framework\View\Element\Template;
use Egits\BrandsList\Model\ResourceModel\Grid\CollectionFactory;

class TopBrands extends Template
{
    protected $gridCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $gridCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->gridCollectionFactory = $gridCollectionFactory;
    }

    /**
     * Get the collection of brand data
     *
     * @return \Egits\BrandsList\Model\ResourceModel\Grid\Collection
     */
    public function getBrandCollection()
    {
        $brandDetail = $this->gridCollectionFactory->create()->getData();
        foreach ($brandDetail as $brand) {
            $brandName = $brand['title'];
            $brandImage = $brand['image'];
            $brandDetails[] = [
                'name' => $brandName,
                'image' => $brandImage,
            ];
            // var_dump($brandName);
            // var_dump($brandImage);
        }
    //    exit;
        
        // var_dump($brandDetails);exit;
       return $brandDetails;
    }
}
