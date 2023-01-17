<?php
namespace Mageget\WebPushNotification\Ui\Component\Listing\Grid\Column;
 
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column; 

 
class Image extends Column
{
    const URL_PATH_EDIT = 'webpushnotification/grid/addrow';
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
  
    /**
     * @var UrlInterface
     */
    protected $url;
 
    /**
     * Image constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
       
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->url = $url; 
        
    }
 
    public function prepareDataSource(array $dataSource)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        
        if (isset($dataSource['data']['items'])) {
            $fieldName = 'image';
            foreach ($dataSource['data']['items'] as & $item) {
                if (!empty($item['image'])) {
                    $name = $item['image'];
                    $item[$fieldName . '_src'] = $mediaUrl.'mageget_webpushnotification/'.$name;
                    $item[$fieldName . '_alt'] = '';
                    $item[$fieldName . '_link'] = $this->url->getUrl(static::URL_PATH_EDIT, [
                        'id' => $item['entity_id']
                    ]);
                    $item[$fieldName . '_orig_src'] = $mediaUrl.'mageget_webpushnotification/'.$name;
                }
            }
        }
        return $dataSource;
    } 
  
 
}