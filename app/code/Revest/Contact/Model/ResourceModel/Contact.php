<?php
namespace Revest\Contact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Contact extends AbstractDb
{
    protected function _construct()
    {

        $this->_init('revest_contact', 'entity_id');
    }
}

