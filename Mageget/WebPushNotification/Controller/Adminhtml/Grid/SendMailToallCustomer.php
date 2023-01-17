<?php
namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
class SendMailToallCustomer extends Action {
    public $collectionFactory;
    protected $helperData;
    protected $_customer;
    protected $transportBuilder;
    public $filter;
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, TransportBuilder $transportBuilder, \Mageget\WebPushNotification\Model\PushNotificationFactory $documentFactory, \Magento\Customer\Model\Customer $customers, \Mageget\WebPushNotification\Helper\Data $helperData) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->documentFactory = $documentFactory;
        $this->transportBuilder = $transportBuilder;
        $this->_customer = $customers;
        $this->helperData = $helperData;
        parent::__construct($context);
    }
    public function execute() {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            $customercount = 0;
            foreach ($collection as $model) {
                $sendstatus = (int)$this->getRequest()->getParam("sendmail");
                if ($sendstatus) {
                    $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->load();
                    foreach ($customersdata as $data) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        try {
                            $requestData = array();
                            $getWebpushEmail = $this->helperData->getWebpushEmail();
                            $getWebpushName = $this->helperData->getWebpushName();
                            $getWebpushEmailTemplateId = $this->helperData->getWebpushEmailTemplateId();
                            $senderName = $getWebpushName;
                            $senderEmail = $getWebpushEmail;
                            $recipientEmail = "$customeremail";
                            $content = $model->getData('content');
                            $eventName = $model->getData('name');
                            $event_desc = $model->getData('title');
                            $identifier = $getWebpushEmailTemplateId; // Enter your email template identifier here
                            $textcontent = "<h3>Hi $customername </h3> <span>$customeremail</span><br/>";
                            $textcontent.= $event_desc;
                           
                            $requestData['textcontent'] = $textcontent;
                            $requestData['templateData'] = $content;
                            $requestData['eventName'] = $eventName;
                            
                            $postObject = new \Magento\Framework\DataObject();
                            $postObject->setData($requestData);
                            $transport = $this->transportBuilder->setTemplateIdentifier($identifier)->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])->setTemplateVars(['data' => $postObject])->setFrom(['name' => $senderName, 'email' => $senderEmail])->addTo([$recipientEmail])->getTransport();
                            $transport->sendMessage();
                            $customercount++;
                        }
                        catch(\Exception $e) {
                            $this->messageManager->addError(__($customeremail . ' Something went wrong. Please try again later.'));
                            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
                        }
                    }  
                }
            }
            $this->messageManager->addSuccess(__('%1 Email has been sent successfully.', $customercount));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
        }
        catch(\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
    }
}
