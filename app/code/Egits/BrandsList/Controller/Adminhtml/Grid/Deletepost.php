<?php

namespace Egits\BrandsList\Controller\Adminhtml\Grid;

class Deletepost extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $blogFactory;
    protected $gridFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Egits\BrandsList\Model\GridFactory $gridFactory
	)
	{
		$this->gridFactory = $gridFactory;
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{

        $resultRedirect = $this->resultRedirectFactory->create();
        $id=$this->getRequest()->getParam('id');
     //  echo $id; exit;
	     try{
	           	   $model = $this->gridFactory->create()->load($id);
				   $model->delete();
		    	$this->messageManager->addSuccessMessage(__('You have deleted the post.'));
			}catch(\Exception $e){
				 $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the post.'));
			}
	 return $resultRedirect->setPath('*/*/');
	}


}