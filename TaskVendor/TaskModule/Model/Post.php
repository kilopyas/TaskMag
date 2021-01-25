<?php
namespace TaskVendor\TaskModule\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'taskvendor_taskmodule_post';

	protected $_cacheTag = 'taskvendor_taskmodule_post';

	protected $_eventPrefix = 'taskvendor_taskmodule_post';

	protected function _construct()
	{
		$this->_init('TaskVendor\TaskModule\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}