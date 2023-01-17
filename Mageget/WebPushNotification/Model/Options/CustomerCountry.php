<?php

namespace Mageget\WebPushNotification\Model\Options;

use Magento\Framework\Option\ArrayInterface;

class CustomerCountry implements ArrayInterface
{

    protected $_customers;
    
    protected $_countryFactory;

    public function __construct(       
        \Magento\Customer\Model\Customer $customers,
        \Magento\Directory\Model\CountryFactory $countryFactory

    )
    {  
        $this->_customers = $customers;
        $this->_countryFactory = $countryFactory;
    
    }

    public function toOptionArray()
    {

        $customersdata =  $this->_customers->getCollection()
        ->addAttributeToSelect("*")
        ->load();

        foreach($customersdata as $data){

            $customerAddress = $data->getAddresses();
            
            foreach($customerAddress as $cdata){

                $countrycode = $cdata->getCountryId();
                $fullCountryName = $this->getCountryName($countrycode);

                    $this->_options[] = ['label' =>$fullCountryName, 'value' => $countrycode];
            }
            
        }
       
        $uniqueCountry = array_map("unserialize", array_unique(array_map("serialize", $this->_options)));

        return $uniqueCountry;
    }

    public function getCountryName($countryCode)
        {    
        $country = $this->_countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
        }
}