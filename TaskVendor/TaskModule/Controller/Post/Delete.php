<?php
namespace TaskVendor\TaskModule\Controller\Post;

use TaskVendor\TaskModule\Model\PostFactory;

class Delete extends \Magento\Framework\App\Action\Action
{
	protected $_postFactory;
    protected $_pageFactory;
    
	public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, PostFactory $postFactory)
	{
		$this->_postFactory = $postFactory;
        $this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
        $id = $this->getRequest()->getParam('id');
        $post = $this->_postFactory->create()->load($id)->delete();
        if($post->save())
            $this->messageManager->addSuccessMessage(__('Data was successfully deleted.'));
        else
            $this->messageManager->addErrorMessage(__('Data was not deleted.'));
        
        // return _redirect('post/post/index');
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('post/post/index');
        return $resultRedirect;
	}
}