<?php
namespace Revest\Contact\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Revest\Contact\Model\Contact;
use Revest\Contact\Model\ResourceModel\Contact as ContactResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Contact::class, ContactResource::class);
    }
}