<?php

namespace Mageget\WebPushNotification\Model;

use Mageget\WebPushNotification\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
   
    protected function _construct()
    {
        $this->_init(\Mageget\WebPushNotification\Model\ResourceModel\PushNotification::class);
    }
    
    /**
     * Get Banner Id
     *
     * @return void
     */
    public function getEntityId()
    {
        return $this->getData(self::ID);
    }
    
    /**
     * Set Banner Id
     *
     * @param  mixed $bannerId
     * @return void
     */
    public function setEntityId($bannerId)
    {
        return $this->setData(self::ID, $bannerId);
    }
    
    /**
     * Get Name
     *
     * @return void
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }
    
    /**
     * Set Name
     *
     * @param  mixed $name
     * @return void
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
    
    /**
     * Gete Title
     *
     * @return void
     */
    public function geteTitle()
    {
        return $this->getData(self::TITLE);
    }
    
    /**
     * Set Title
     *
     * @param  mixed $title
     * @return void
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }
    
    /**
     * Gete Content
     *
     * @return void
     */
    public function geteContent()
    {
        return $this->getData(self::CONTENT);
    }
    
    /**
     * Set Content
     *
     * @param  mixed $content
     * @return void
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }
    
    /**
     * Gete Image
     *
     * @return void
     */
    public function geteImage()
    {
        return $this->getData(self::IMAGE);
    }
    
    /**
     * Set Image
     *
     * @param  mixed $image
     * @return void
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Gete Status
     *
     * @return void
     */
    public function geteStatus()
    {
        return $this->getData(self::STATUS);
    }
    
    /**
     * Set Status
     *
     * @param  mixed $status
     * @return void
     */
    public function setStatus($status)
    {
        return $this->setData(self::IMAGE, $status);
    }
        
    /**
     * Get CreatedAt
     *
     * @return void
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
    
    /**
     * Set CreatedAt
     *
     * @param  mixed $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
