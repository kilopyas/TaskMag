<?php
namespace TaskVendor\TaskModule\Controller\Post;

use TaskVendor\TaskModule\Model\PostFactory;

class Save extends \Magento\Framework\App\Action\Action
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
        $requests = $this->getRequest()->getParams();
        print_r($requests);
        exit;
        $post = $this->_postFactory->create();
        $post->setName($requests['name']);
        $post->setUrlKey($requests['url']);
        $post->setPostContent($requests['content']);
        $post->setTags($requests['tags']);

        if($post->save())
            $this->messageManager->addSuccessMessage(__('Data was successfully saved.'));
        else
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        
        // return _redirect('post/post/index');
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('post/post/save');
        return $resultRedirect;
	}
}