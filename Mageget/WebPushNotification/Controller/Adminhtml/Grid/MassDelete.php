<?php

namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;

class MassDelete extends Action
{
    public $collectionFactory;

    public $filter;
    protected $pushNotification;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Mageget\WebPushNotification\Model\PushNotificationFactory $pushNotification
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->pushNotification = $pushNotification;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            $count = 0;
            foreach ($collection as $model) {
                $model = $this->pushNotification->create()->load($model->getId());
                $model->delete();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 rows have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('webpushnotification/grid/index');
    }

}