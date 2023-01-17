<?php
namespace Mageget\WebPushNotification\Controller\Adminhtml\Grid;
class Delete extends \Magento\Backend\App\Action {
    public function execute() {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Mageget\WebPushNotification\Model\PushNotification::class);
                $model->load($id);
                $title = $model->getName();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The row has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch('webpushnotification_grid_on_delete', ['title' => $title, 'status' => 'success']);
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e) {
                $this->_eventManager->dispatch('adminhtml_grid_on_delete', ['title' => $title, 'status' => 'fail']);
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a news to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
