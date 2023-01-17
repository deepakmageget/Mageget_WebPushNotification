<?php

namespace Mageget\WebPushNotification\Block\Adminhtml\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;
use Magento\Backend\Block\Widget\Context;

class SendGroupMail extends Generic implements ButtonProviderInterface
{
    protected $context;
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getButtonData()
    {


        return [
            'label' => __('Send Email'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'webpush_customer_group_form.webpush_customer_group_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,[
                                        'template_entity_id' => $this->entity_id(),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


    public function entity_id()
    {
       return $entity_id = $this->context->getRequest()->getParam('entity_id');
        
       
    }

}