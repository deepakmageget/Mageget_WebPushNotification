<?php
namespace Mageget\WebPushNotification\Block\Adminhtml\Grid\Edit;
/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    
   

    protected $_systemStore;
    protected $_groupOptions;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Mageget\WebPushNotification\Model\Status $options, 
        \Mageget\WebPushNotification\Block\Adminhtml\Grid\AddRow $groupOptions, 
        array $data = []
    ) 
    {
        $this->_options = $options;
        $this->_groupOptions = $groupOptions;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    
    protected function _prepareForm()
    { 
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT); 
      
        // $mediaUrl = $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
       

        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'post'
                        ]
            ]
        );
        $form->setHtmlIdPrefix('magegrid_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Event '), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add New Event Data'), 'class' => 'fieldset-wide']
            );
        }
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Event Name'),
                'id' => 'name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Event Description'),
                'id' => 'title',
                'title' => __('Title'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'content',
            'textarea',
            [
                'name' => 'content',
                'label' => __('Add Template Code'),
                'id' => 'content',
                'title' => __('Emailer Code'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

    $fieldset->addField(
        'customer_group',
        'multiselect',
        [
            'label' => __('Customer Group'),
            'title' => __('Customer Group'),
            'name' => 'customer_group',
            'values' => $this->_groupOptions->getOptionArray2()
            
        ]
    );
   
    $fieldset->addField(
        'frequency',
        'select',
        [
            'label' => __('Frequency'),
            'title' => __('Frequency'),
            'name' => 'frequency',
            'options' => $this->_groupOptions->getOptionArray3()
            
        ]
    );

    // $fieldset->addField(
    //     'time',
    //     'time',
    //     [
    //         'name' => 'time',
    //         'label' => __('Start Time'),
    //         'id' => 'time',
    //         'title' => __('Time'),
    //         'class' => 'required-entry'
    //     ]
    // );


    //  $fieldset->addField(
    //     'image',
    //     'image', 
    //     [
    //         'name' => 'image',
    //         'label' => __('Upload Image'),
    //         'title' => __('Upload Image'),
    //         'required' => true,
    //         'note' => 'Allow image type: jpg, jpeg, png',
    //         'class' => 'required-entry required-file',
    //     ]
    // );

         
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    
}