<?php

namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid; 


class Viewemailtemplate extends \Magento\Backend\App\Action
{
  
    var $gridFactory;
      protected $_resultPageFactory;
      protected $_webPushNotification;
  
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageget\WebPushNotification\Model\GridFactory $gridFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mageget\WebPushNotification\Model\PushNotificationFactory $WebPushNotification
       
    ) {
        parent::__construct($context); 
        $this->gridFactory = $gridFactory; 
        $this->_webPushNotification = $WebPushNotification;
         $this->_resultPageFactory = $resultPageFactory; 
    }  

    public function execute()
    {

      
        $resultPage = $this->_resultPageFactory->create();

        $resultPage->setActiveMenu('Mageget_WebPushNotification::grid_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Template View'));
      
      
 return $resultPage;
      
    }

  
}