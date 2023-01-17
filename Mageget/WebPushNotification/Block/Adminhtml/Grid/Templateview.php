<?php

namespace Mageget\WebPushNotification\Block\Adminhtml\Grid;

class Templateview extends \Magento\Framework\View\Element\Template
{   
    protected $_modelFactory;

public function __construct(
    \Magento\Backend\Block\Template\Context $context, 
    \Mageget\WebPushNotification\Model\PushNotificationFactory $modelFactory,
    array $data = []

    ) {
     $this->_modelFactory =  $modelFactory;
    parent::__construct($context, $data);
    }
  
    public function getEmailTemplate($templatecustomviewId)
    {
   
      $model = $this->_modelFactory->create();
        return $collection = $model->load($templatecustomviewId);
       
    }


}


