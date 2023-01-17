<?php
namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use \Magento\Customer\Model\Customer;
class CustomSendEmail extends Action {
    public $collectionFactory;
    protected $_customer;
    protected $transportBuilder;
    public $filter;
    protected $helperData;
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, TransportBuilder $transportBuilder, Customer $customers, \Mageget\WebPushNotification\Helper\Data $helperData) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->_customer = $customers;
        $this->helperData = $helperData;
        parent::__construct($context);
    }
    /**
     * Execute
     *
     * @return void
     */
    public function execute() {
        $enabled = $this->helperData->isModuleEnabled();
        $getWebpushEmail = $this->helperData->getWebpushEmail();
        $getWebpushName = $this->helperData->getWebpushName();
        $getWebpushEmailTemplateId = $this->helperData->getWebpushEmailTemplateId();
        $data = $this->getRequest()->getPostValue();
        $select_customer = $data['select_customer'];
        $customer_country = $data['customer_country'];
        $template_entity_id = $data['template_entity_id'];
        $senderName = $getWebpushName;
        $senderEmail = $getWebpushEmail;
        if ($select_customer) {
            $customer_country = $data['customer_country'];
            $collection = $this->collectionFactory->create()->addFieldToFilter('entity_id', $template_entity_id);
            foreach ($collection as $templaData) {
                $template_name = $templaData->getData('name');
                $template_title = $templaData->getData('title');
                $template_content = $templaData->getData('content');
            }
            $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->load();
            $customercount = 0;
            foreach ($customersdata as $data) {
                $customerAddress = $data->getAddresses();
                foreach ($customerAddress as $cdata) {
                    $countrycode = $cdata->getCountryId();
                    if (in_array($countrycode, $customer_country)) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        try {
                        $this->sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_title, $template_content);
                        $customercount++;
                        } catch(\Exception $e) {
                            $this->messageManager->addError(__($e->getMessage()));
                            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
                        }
                    }
                }
            }
            $this->messageManager->addSuccess(__('%1 Email has been sent successfully.', $customercount));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
        } else {
            $customer_emails = $data['customer_email'];
            try {
                $collection = $this->collectionFactory->create()->addFieldToFilter('entity_id', $template_entity_id);
                
                foreach ($collection as $templaData) {
                    $template_name = $templaData->getData('name');
                    $template_title = $templaData->getData('title');
                    $template_content = $templaData->getData('content');
                }
                $customercount = 0;
                foreach ($customer_emails as $customer_email) {
                    $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->addFieldToFilter('email', $customer_email)->load();
                    foreach ($customersdata as $data) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        try {
                            $this->sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_title, $template_content);
                            $customercount++;
                            } catch(\Exception $e) {
                                $this->messageManager->addError(__($e->getMessage()));
                                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
                            }
                    }
                }
                $this->messageManager->addSuccess(__('%1 Email has been sent successfully.', $customercount));
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath("webpushnotification/grid/index");
            }
            catch(\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        }
    }
    public function sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_desce, $template_code) {
        $requestData = array();
        $identifier = $this->helperData->getWebpushEmailTemplateId(); // Enter your email template identifier here
        $textcontent = "<h3>Hi $customername </h3> <span>$customeremail</span><br/>";
        $textcontent.= $template_desce;
        $recipientEmail = $customeremail;
        $requestData['textcontent'] = $textcontent;
        $requestData['templateData'] = $template_code;
        $requestData['eventName'] = $template_name;
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($requestData);
        $transport = $this->transportBuilder->setTemplateIdentifier($identifier)->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])->setTemplateVars(['data' => $postObject])->setFrom(['name' => $senderName, 'email' => $senderEmail])->addTo([$recipientEmail])->getTransport();
        $transport->sendMessage();
    }
}
