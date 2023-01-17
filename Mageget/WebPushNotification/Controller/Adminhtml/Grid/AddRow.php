<?php

namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;
use Magento\Framework\Controller\ResultFactory;
class AddRow extends \Magento\Backend\App\Action
{
   
    private $coreRegistry;
  
    private $gridFactory;
  
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Mageget\WebPushNotification\Model\GridFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->gridFactory = $gridFactory;
    }
 
    public function execute()
    {
       
        $rowId = (int) $this->getRequest()->getParam('entity_id');
        $rowData = $this->gridFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowName = $rowData->getName();
           if (!$rowData->getEntityId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('webpushnotification/grid/rowdata');
               return;
           }
       }
       $this->coreRegistry->register('row_data', $rowData);
       $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       $title = $rowId ? __('Edit Template : ').$rowName : __('Add New Template');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mageget_WebPushNotification::addrow');
    }
}