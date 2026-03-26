<?php
namespace Revest\Contact\Model;

/**
 * Contact model (revest_contact table)
 */
class Contact extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Revest\Contact\Model\ResourceModel\Contact::class);
    }
}