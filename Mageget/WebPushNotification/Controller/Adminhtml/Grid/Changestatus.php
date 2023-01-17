<?php
namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;

class ChangeStatus extends Action {
    public $collectionFactory;
    public $filter;
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute() {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $model) {
                $status = (int)$this->getRequest()->getParam('changestatus');
                $templates = 0;
                foreach ($collection as $template) {
                    try {
                        $template->setStatus($status)->save();
                        $templates++;
                    }
                    catch(Exception $e) {
                        $this->messageManager->addErrorMessage(__('Something went wrong while updating status for %1.', $template->getName()));
                    }
                }
            }
            if ($templates) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $templates));
            } else {
                $this->messageManager->addSuccess(__('A total of %1 record(s) have been updated.', $templates));
            }
        }
        catch(\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('webpushnotification/grid/index');
    }
}
