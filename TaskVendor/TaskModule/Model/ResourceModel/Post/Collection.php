<?php
namespace TaskVendor\TaskModule\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'post_id';
	protected $_eventPrefix = 'taskvendor_taskmodule_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('TaskVendor\TaskModule\Model\Post', 'TaskVendor\TaskModule\Model\ResourceModel\Post');
	}

}