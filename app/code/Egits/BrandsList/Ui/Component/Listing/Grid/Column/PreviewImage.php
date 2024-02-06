<?php

namespace Egits\BrandsList\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class PreviewImage extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                // Make sure the key 'image' matches your actual data source key
                if (isset($item['image']) && $item['image']) {
                    $item[$this->getData('name')] = '<img src="' . $item['image'] . '"  height="100"/>';
                } else {
                    $item[$this->getData('name')] = '';
                }
            }
        }

        return $dataSource;
    }
}