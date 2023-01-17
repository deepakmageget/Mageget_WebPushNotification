<?php

namespace Mageget\WebPushNotification\Model;

 

use Mageget\WebPushNotification\Model\ResourceModel\Grid\CollectionFactory;

 

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider

{

    public function __construct(

        $name,

        $primaryFieldName,

        $requestFieldName,

        CollectionFactory $employeeCollectionFactory,

        array $meta = [],

        array $data = []

    ) {

        $this->collection = $employeeCollectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

    }

    public function getData()

    {

        return [];

    }

}