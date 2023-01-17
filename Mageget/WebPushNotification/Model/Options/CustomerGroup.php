<?php
namespace Mageget\WebPushNotification\Model\Options;

use Magento\Framework\Option\ArrayInterface;

class CustomerGroup implements ArrayInterface
{

protected $_customerGroup;

public function __construct(

\Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup

) {
    $this->_customerGroup = $customerGroup; 
}

public function toOptionArray()
{

    $customerGroups = $this->_customerGroup->toOptionArray();

    foreach($customerGroups as $cg){
      
        if($cg['label'] !== 'NOT LOGGED IN'){

            $this->_options[] = ['label' => $cg['label'], 'value' => $cg['value']];
        }
       
    }

    return $this->_options;       
}

}