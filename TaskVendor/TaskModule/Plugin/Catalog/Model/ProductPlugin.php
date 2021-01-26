<?php

namespace TaskVendor\TaskModule\Plugin\Catalog\Model;

use Magento\Catalog\Model\Product;

class ProductPlugin
{
    public function afterGetName(Product $subject, $result)
    {
        return $result. ' modified by After Plugin';
    }
}