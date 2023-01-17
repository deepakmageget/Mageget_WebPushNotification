<?php

namespace Mageget\WebPushNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Custom fee config path
     */
    const CONFIG_CUSTOM_IS_ENABLED = 'webpushnotification/general/enable';
   
    const WEBPUSH_NAME = 'webpushnotification/mageget_webpushemail/webpush_name';
    const WEBPUSH_EMAIL = 'webpushnotification/mageget_webpushemail/webpush_email';
    const WEBPUSH_EMAIL_TEMPLATE_ID = 'webpushnotification/mageget_webpushemail/webpush_email_template_id';


    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_CUSTOM_IS_ENABLED, $storeScope);
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getWebpushEmail()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::WEBPUSH_EMAIL, $storeScope);
    }
    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getWebpushName()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::WEBPUSH_NAME, $storeScope);
    }
    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getWebpushEmailTemplateId()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::WEBPUSH_EMAIL_TEMPLATE_ID, $storeScope);
    }




}
