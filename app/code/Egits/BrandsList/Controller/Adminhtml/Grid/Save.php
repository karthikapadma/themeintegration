<?php

namespace Egits\BrandsList\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;

class Save extends Action
{
    protected $gridFactory;
    protected $filesystem;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Egits\BrandsList\Model\GridFactory $gridFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        $this->filesystem = $filesystem;
    }


    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $baseurl = $storeManager->getStore()->getBaseUrl();
        $baseurl = str_replace("index.php/", "", $baseurl);
        //  var_dump($baseurl);dd();
        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // dd();
        if (!$data) {
            $this->_redirect('topbrands/grid/addrow');
            return;
        }

        try {
            $rowData = $this->gridFactory->create();

            // Handle image upload
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $uploader = $this->_objectManager->create(\Magento\MediaStorage\Model\File\Uploader::class, ['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

                $result = $uploader->save($mediaDirectory->getAbsolutePath('Grid/images'));

                $data['image'] = $baseurl . 'media/Grid/images/' . $result['file'];
                // var_dump($baseurl);
                // dd();
            }

            // Handle email field
            // if (isset($data['email'])) {
            //     $rowData->setEmail($data['email']);
            // }

            // Set other data to your model
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }

            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('topbrands/grid/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Topbands_Grid::save');
    }
}
