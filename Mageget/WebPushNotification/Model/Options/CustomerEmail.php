<?php

namespace Mageget\WebPushNotification\Model\Options;

use Magento\Framework\Option\ArrayInterface;

class CustomerEmail implements ArrayInterface
{

    protected $_customers;

    public function __construct(       
        \Magento\Customer\Model\Customer $customers
    )
    {  
        $this->_customers = $customers;
    }
    public function toOptionArray()
    {
        $customersdata =  $this->_customers->getCollection()
        ->addAttributeToSelect("*")
        ->load();

        foreach($customersdata as $data){
            $customername = $data->getData('firstname')." ".$data->getData('lastname');
            $customeremail = $data->getData('email');

            $this->_options[] = ['label' => $customeremail, 'value' => $customeremail];
        }

        return $this->_options;
    }
}