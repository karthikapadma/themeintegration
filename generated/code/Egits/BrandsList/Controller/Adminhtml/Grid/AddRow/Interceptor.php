<?php
namespace Egits\BrandsList\Controller\Adminhtml\Grid\AddRow;

/**
 * Interceptor class for @see \Egits\BrandsList\Controller\Adminhtml\Grid\AddRow
 */
class Interceptor extends \Egits\BrandsList\Controller\Adminhtml\Grid\AddRow implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Egits\BrandsList\Model\GridFactory $gridFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $gridFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
