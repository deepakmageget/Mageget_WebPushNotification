<?php

namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid; 

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;

class Save extends \Magento\Backend\App\Action
{
    var $gridFactory;

	protected $uploaderFactory;

    protected $adapterFactory;

    protected $filesystem;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageget\WebPushNotification\Model\GridFactory $gridFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem
    ) {
        parent::__construct($context); 
        $this->gridFactory = $gridFactory;  
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }  

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('webpushnotification/grid/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();



            if(isset($data['customer_group'])){
                $customer_group = $data['customer_group'];
                $customer_group = implode(',', $customer_group);
            $data['customer_group'] = $customer_group;
            }
           
    
                    // $files = $this->getRequest()->getFiles('image');
                    // $target = $this->_mediaDirectory->getAbsolutePath('mageget_webpushnotification/');        
                    // //attachment is the input file name posted from your form
                    // $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                    // $_fileType = $uploader->getFileExtension();
                    // $uniqid = uniqid();
                    // $newFileName = $uniqid .'.'. $_fileType;
                    // $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                    // $uploader->setAllowRenameFiles(true);
                    // $result = $uploader->save($target,$newFileName); 

                // $data['image'] =  $newFileName;
           
                  $rowData->setData($data);

             if (isset($data['entity_id'])) {
               $rowData->setEntityId($data['entity_id']);                 
            }  

         $rowData->save();
            $this->messageManager->addSuccess(__('Record has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('webpushnotification/grid/index');
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mageget_WebPushNotification::save');
    }
}