<?php
namespace Mageget\WebPushNotification\Model\ResourceModel\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * _construct
     *
     * @return void
     */
    public function _construct()
    {
        // @codingStandardsIgnoreLine
        $this->_init('Mageget\WebPushNotification\Model\PushNotification', 'Mageget\WebPushNotification\Model\ResourceModel\PushNotification');
    }
}
