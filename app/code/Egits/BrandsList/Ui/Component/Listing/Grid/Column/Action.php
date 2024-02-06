<?php

namespace Egits\BrandsList\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\Phrase;

class Action extends Column
{
    /** Url path */
    const ROW_EDIT_URL = 'topbrands/grid/addrow';
    /** @var UrlInterface */
    const ROW_DELETE_URL = 'topbrands/grid/deletepost';

    protected $_urlBuilder;

    /**
     * @var string
     */
    private $_editUrl;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
  * thecoachsmb_article_grids  * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                // $email = $this->getData('email');
    
                if (isset($item['id'])) {
                    // Edit and Delete options for select dropdown
                    $item[$name]['actions'] = [
                        'edit' => [
                            'href' => $this->_urlBuilder->getUrl(
                                $this->_editUrl,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Edit'),
                        ],
                        'delete' => [
                            'href' => $this->_urlBuilder->getUrl(
                                self::ROW_DELETE_URL,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete'),
                                'message' => __('Are you sure you want to delete "%1 - %2" record?', $item['title']),
                            ],
                        ],
                    ];
    
                    // Edit and Delete buttons
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_editUrl,
                            ['id' => $item['id']]
                        ),
                        'label' => __('Edit'),
                    ];
    
                    $item[$name]['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            self::ROW_DELETE_URL,
                            ['id' => $item['id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you want to delete "%1 - %2" record?', $item['title']),
                        ],
                    ];
                }
            }
        }
    
        return $dataSource;
    }
}