<?php

namespace Mageget\WebPushNotification\Ui\Component\Listing\Grid\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class PageActions
 */
class Action extends Column
{
    /** Url path */
    const CMS_URL_PATH_EDIT = 'webpushnotification/grid/addrow';
    const CMS_URL_PATH_VIEW = 'webpushnotification/grid/viewemailtemplate';
    const CMS_URL_PATH_DELETE = 'webpushnotification/grid/delete';
    const CMS_URL_PATH_SPECIFIC_CUSTOMER = 'webpushnotification/grid/sendmailtocustomer';
    const CMS_URL_PATH_SPECIFIC_GROUP_CUSTOMER = 'webpushnotification/grid/sendspecificgroupcustomer';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;
    /**
     * @var string
     */
    private $viewurl;
    private $sendspecificCustomer;
    private $sendspecificgroupCustomer;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::CMS_URL_PATH_EDIT,
        $viewurl = self::CMS_URL_PATH_VIEW,
        $sendspecificCustomer = self::CMS_URL_PATH_SPECIFIC_CUSTOMER,
        $sendspecificgroupCustomer = self::CMS_URL_PATH_SPECIFIC_GROUP_CUSTOMER
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->viewurl = $viewurl;
        $this->sendspecificCustomer = $sendspecificCustomer;
        $this->sendspecificgroupCustomer = $sendspecificgroupCustomer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['entity_id' => $item['entity_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['View Template'] = [
                        'href' => $this->urlBuilder->getUrl($this->viewurl, ['entity_id' => $item['entity_id']]),
                        'label' => __('View Template')
                    ];

                    $item[$name]['Send Mail to Email or Country Basis'] = [
                        'href' => $this->urlBuilder->getUrl($this->sendspecificCustomer, ['entity_id' => $item['entity_id']]),
                        'label' => __('Send Mail to Email or Country Basis ')
                    ];

                    $item[$name]['Send Mail to Customer Group Basis'] = [
                        'href' => $this->urlBuilder->getUrl($this->sendspecificgroupCustomer, ['entity_id' => $item['entity_id']]),
                        'label' => __('Send Mail to Customer Group Basis ')
                    ];

                    $title = $this->getEscaper()->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::CMS_URL_PATH_DELETE, ['entity_id' => $item['entity_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title)
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get instance of escaper
     * @return Escaper
     * @deprecated 101.0.7
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
