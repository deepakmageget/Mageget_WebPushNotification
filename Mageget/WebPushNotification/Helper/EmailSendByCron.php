<?php
namespace Mageget\WebPushNotification\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Customer\Model\Customer;
use Mageget\WebPushNotification\Helper\Data;
class EmailSendByCron extends AbstractHelper {
    public $collectionFactory;
    protected $_customer;
    protected $transportBuilder;
    protected $helperData;
    public function __construct(
        CollectionFactory $collectionFactory, 
        Filter $filter, TransportBuilder $transportBuilder, 
        Customer $customers, 
        Data $helperData) {
        $this->collectionFactory = $collectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->_customer = $customers;
        $this->helperData = $helperData;
    }
    public function EmailSendDailyBasis() {
        $getWebpushEmail = $this->helperData->getWebpushEmail();
        $getWebpushName = $this->helperData->getWebpushName();
        $getWebpushEmailTemplateId = $this->helperData->getWebpushEmailTemplateId();
        $collection = $this->collectionFactory->create()->addFieldToFilter('frequency', 'D');
        foreach ($collection as $templaData) {
            $template_status = $templaData->getData('status');
            if ($template_status) {
                $template_name = $templaData->getData('name');
                $template_title = $templaData->getData('title');
                $template_content = $templaData->getData('content');
                $customer_group = $templaData->getData('customer_group');
                $customer_group = explode(',', $customer_group);
                $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->load();
                $customercount = 0;
                foreach ($customersdata as $data) {
                    $group_id = $data->getData('group_id');
                    if (in_array($group_id, $customer_group)) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        $senderName = $getWebpushName;
                        $senderEmail = $getWebpushEmail;
                        $this->sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_title, $template_content);
                        $customercount++;
                    }
                }
            }
        }
        return $customercount . " Mail Send Successfully.";
    }
    public function EmailSendWeeklyBasis() {
        $getWebpushEmail = $this->helperData->getWebpushEmail();
        $getWebpushName = $this->helperData->getWebpushName();
        $getWebpushEmailTemplateId = $this->helperData->getWebpushEmailTemplateId();
        $collection = $this->collectionFactory->create()->addFieldToFilter('frequency', 'W');
        foreach ($collection as $templaData) {
            $template_status = $templaData->getData('status');
            if ($template_status) {
                $template_name = $templaData->getData('name');
                $template_title = $templaData->getData('title');
                $template_content = $templaData->getData('content');
                $customer_group = $templaData->getData('customer_group');
                $customer_group = explode(',', $customer_group);
                $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->load();
                $customercount = 0;
                foreach ($customersdata as $data) {
                    $group_id = $data->getData('group_id');
                    if (in_array($group_id, $customer_group)) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        $senderName = $getWebpushName;
                        $senderEmail = $getWebpushEmail;
                        $this->sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_title, $template_content);
                        $customercount++;
                    }
                }
            }
        }
        return $customercount . " Mail Send Successfully.";
    }
    public function EmailSendMonthlyBasis() {
        $getWebpushEmail = $this->helperData->getWebpushEmail();
        $getWebpushName = $this->helperData->getWebpushName();
        $getWebpushEmailTemplateId = $this->helperData->getWebpushEmailTemplateId();
        $collection = $this->collectionFactory->create()->addFieldToFilter('frequency', 'M');
        foreach ($collection as $templaData) {
            $template_status = $templaData->getData('status');
            if ($template_status) {
                $template_name = $templaData->getData('name');
                $template_title = $templaData->getData('title');
                $template_content = $templaData->getData('content');
                $customer_group = $templaData->getData('customer_group');
                $customer_group = explode(',', $customer_group);
                $customersdata = $this->_customer->getCollection()->addAttributeToSelect("*")->load();
                $customercount = 0;
                foreach ($customersdata as $data) {
                    $group_id = $data->getData('group_id');
                    if (in_array($group_id, $customer_group)) {
                        $customername = $data->getData('firstname') . " " . $data->getData('lastname');
                        $customeremail = $data->getData('email');
                        $senderName = $getWebpushName;
                        $senderEmail = $getWebpushEmail;
                        $this->sendMailToCustomer($customername, $customeremail, $senderName, $senderEmail, $template_name, $template_title, $template_content);
                        $customercount++;
                    }
                }
            }
        }
        return $customercount . " Mail Send Successfully.";
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
