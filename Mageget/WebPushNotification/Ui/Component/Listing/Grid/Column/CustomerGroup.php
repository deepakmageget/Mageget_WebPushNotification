<?php
namespace Mageget\WebPushNotification\Ui\Component\Listing\Grid\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Customer\Model\ResourceModel\Group\Collection;
/**
 * Class CustomerGroup
*/
 class CustomerGroup extends Column
 {
    private $urlBuilder;
    protected $helper;
    protected $_customerGroup;

    public function __construct(
       ContextInterface $context,
       UiComponentFactory $uiComponentFactory,
       UrlInterface $urlBuilder,
       Collection $customerGroup,
       array $components = [],
       array $data = []
    ) {
       parent::__construct($context, $uiComponentFactory, 
       $components, $data
    );
       $this->urlBuilder = $urlBuilder;
       $this->_customerGroup = $customerGroup; 
    }
  public function prepareDataSource(array $dataSource)
   {
    if (isset($dataSource['data']['items'])) {
        $fieldName = 'customer_group';
        foreach ($dataSource['data']['items'] as & $item) {
            if (!empty($item['customer_group'])) {
                $customer_group_id = $item['customer_group'];
                $customer_group_id = explode(",",$customer_group_id);
                $customerGroups = $this->_customerGroup->toOptionArray();
                $arrData = array();
                foreach($customerGroups as $cg){
                    if(in_array($cg['value'],$customer_group_id)){
                        $arrData []= $cg['label'];
                    }
                }
                $customer_lable = implode(" | ",$arrData);
                $item[$fieldName] = $customer_lable;
            }
        }
    }
    return $dataSource;
  }
} 