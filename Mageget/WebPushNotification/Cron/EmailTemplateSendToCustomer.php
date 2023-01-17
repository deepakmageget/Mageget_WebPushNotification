<?php
Namespace Mageget\WebPushNotification\Cron;

use Psr\Log\LoggerInterface;
use Mageget\WebPushNotification\Helper\EmailSendByCron;

class EmailTemplateSendToCustomer {

    protected $logger;
    protected $helperData;
    
    public function __construct(
        LoggerInterface $logger,
        EmailSendByCron $helperData
        
    ) {
        $this->logger = $logger;
        $this->helperData = $helperData;
    }

    public function execute(){
        $this->logger->info('Cron Works Deepak');
    }

    public function sendDailyBasis(){
      
        $data = $this->helperData->EmailSendDailyBasis();
        $this->logger->info('Daily Send Email Status - '. $data);
    }

    public function sendWeeklyBasis(){
        $data = $this->helperData->EmailSendWeeklyBasis();
        $this->logger->info('Weekly Send Email Status - '. $data);
    }
    
    public function sendMonthlyBasis(){
        $data = $this->helperData->EmailSendMonthlyBasis();
        $this->logger->info('Monthly Send Email Status - '. $data);
    }
}


// $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/logfile.log');
// $logger = new \Zend\Log\Logger();
// $logger->addWriter($writer);
// $logger->info('Log Data'); // Log Data
// $logger->info('Print Array Data'.print_r($myArrayVar, true)); // Print Array Data