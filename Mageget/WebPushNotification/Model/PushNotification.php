<?php
namespace Mageget\WebPushNotification\Model;

use Magento\Cron\Exception;
use Magento\Framework\Model\AbstractModel;

class PushNotification extends AbstractModel
{
      
    /**
     * _dateTime $_dateTime
     *
     * @var mixed
     */
    protected $_dateTime;
    
    /**
     * _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mageget\WebPushNotification\Model\ResourceModel\PushNotification::class);
    }
}
