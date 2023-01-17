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
 class CustomerFrequency extends Column
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
        $fieldName = 'frequency';
        foreach ($dataSource['data']['items'] as & $item) {
            if (!empty($item['frequency'])) {
                $frequency = $item['frequency'];

                if($frequency == "D"){
                    $item[$fieldName] = "Daily";
                }
                if($frequency == "W"){
                    $item[$fieldName] = "Weekly";
                }
                if($frequency == "M"){
                    $item[$fieldName] = "Monthly";
                }
                 
            }
        }
    }
    return $dataSource;
  }
} 