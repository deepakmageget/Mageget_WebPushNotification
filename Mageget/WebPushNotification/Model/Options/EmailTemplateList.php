<?php
namespace Mageget\WebPushNotification\Model\Options;

use Magento\Framework\Option\ArrayInterface;
use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;

class EmailTemplateList implements ArrayInterface
{

    protected $collectionFactory;

public function __construct(

    CollectionFactory $collectionFactory

) {
    $this->collectionFactory = $collectionFactory;
}

public function toOptionArray()
{

    $collection = $this->collectionFactory->create();




    foreach ($collection as $templaData) {

        $template_entity_id = $templaData->getData('entity_id');
        $template_name = $templaData->getData('name');
        $this->_options[] = ['label' => $template_name, 'value' => $template_entity_id];
    }



    // foreach($customerGroups as $cg){
      
    //     if($cg['label'] !== 'NOT LOGGED IN'){

    //         $this->_options[] = ['label' => $cg['label'], 'value' => $cg['value']];
    //     }
       
    // }

    return $this->_options;       
}

}