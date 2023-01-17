<?php

namespace Mageget\WebPushNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PushNotification extends AbstractDb
{
    
    public function _construct()
    {
        $this->_init("mageget_webpushnotification", "entity_id");
    }
}
