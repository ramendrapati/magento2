<?php
namespace Revest\Contact\Model;

use Revest\Contact\Api\ContactManagementInterface;
use Revest\Contact\Model\ContactFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;

class ContactManagement implements ContactManagementInterface
{
    protected $contactFactory;
    protected $scopeConfig;
    protected $transportBuilder;
    protected $storeManager;

    const XML_PATH_EMAILS = 'revest_contact/general/recipients';

    public function __construct(
        ContactFactory $contactFactory,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->contactFactory = $contactFactory;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
    }

    public function save(string $name, string $email, string $telephone, string $comment): bool
    {
        // Save data
        $model = $this->contactFactory->create();
        $model->setData([
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
            'comment' => $comment
        ]);
        $model->save();

        // Get emails from config
        $emails = $this->scopeConfig->getValue(self::XML_PATH_EMAILS);
        
        if (!$emails) {
            return true;
        }

        // Convert to array + clean
        $emailList = array_filter(array_map('trim', explode(',', $emails)));

        // Validate emails
        $emailList = array_filter($emailList, function ($e) {
            return filter_var($e, FILTER_VALIDATE_EMAIL);
        });

        if (empty($emailList)) {
            return true;
        }
        // $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        // $logger = new \Zend_Log();
        // $logger->addWriter($writer);
        // $logger->info(print_r($emailList,true));
        try {
            $storeId = $this->storeManager->getStore()->getId();

            $transport = $this->transportBuilder
                ->setTemplateIdentifier('revest_contact_email_template')
                ->setTemplateOptions([
                    'area' => Area::AREA_FRONTEND,
                    'store' => $storeId
                ])
                ->setTemplateVars([
                    'name' => $name,
                    'email' => $email,
                    'telephone' => $telephone,
                    'comment' => $comment
                ])
                ->setFromByScope('general')
                ->addTo($emailList) // multiple recipients
                ->getTransport();

            $transport->sendMessage();

        } catch (\Exception $e) {
            // Optional: log error
        }

        return true;
    }
}