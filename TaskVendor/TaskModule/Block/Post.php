<?php
namespace TaskVendor\TaskModule\Block;

use Magento\Framework\Data\Form\FormKey;

class Post extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;
    protected $_formKey;
    
	public function __construct(\Magento\Framework\View\Element\Template\Context $context, \TaskVendor\TaskModule\Model\PostFactory $postFactory, FormKey $formKey, array $data = [])
	{
        $this->_postFactory = $postFactory;
        $this->_formKey = $formKey;
		parent::__construct($context, $data);
	}

    public function getFormKey()
    {
         return $this->_formKey->getFormKey();
    }

	public function getPostCollection(){
		$post = $this->_postFactory->create();
		return $post->getCollection();
    }

    public function redirectSave(){
        return $this->getUrl('post/post/save');
    }

    public function getAddUrl(){
        return $this->getUrl('post/post/add');
    }

    public function getEditUrl(){
        return $this->getUrl('post/post/edit');
    }
}