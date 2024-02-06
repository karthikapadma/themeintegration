<?php

namespace Egits\BrandsList\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Egits\BrandsList\Model\Grid', 'Egits\BrandsList\Model\ResourceModel\Grid');
    }
}