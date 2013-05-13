<?php
class Bitcoincenter_Btcpay_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'bitcoincenter';
    //protected $_code = 'btcpay';
    protected $_isInitializeNeeded     = false;
    protected $_isGateway               = true;
    protected $_canAuthorize            = true;
    protected $_canCapture              = true;
    protected $_canCapturePartial       = false;
    protected $_canRefund               = false;
    protected $_canVoid                 = false;
    protected $_canUseInternal          = true;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = false;
    protected $_canSaveCc = false;
    private $_order = null;
 
    /**
     * this method is called if we are just authorising
     * a transaction
     */
    public function authorize (Varien_Object $payment, $amount)
    {
		Mage::log('authorize');
    }

    /**
     * this method is called if we are authorising AND
     * capturing a transaction
     */
    public function capture(Varien_Object $payment, $amount)
    {
        
            Mage::log('capture');


        return $this;
    }

    public function void(Varien_Object $payment) {
		Mage::log('void');
	}
	
	 public function getOrderPlaceRedirectUrl() {
		 // $checkoutSession->getLastOrderId();
		$quote_id = Mage::getSingleton('checkout/session')->getQuoteId();
		$quote = Mage::getModel('sales/quote')->load($quote_id);
		Mage::log('quote_id: '.$quote_id);
		Mage::log('total: '.$quote->getData('grand_total'));
		
		return Mage::getUrl('btcpay/btcpay/', array('quote_id' => $quote_id));
	 }

   
    
    public function isAvailable($quote = NULL)
    {
        return Mage::getStoreConfig('payment/btcpay/active');
    }
    public function canUseForCurrency($currencyCode)
    {
        return TRUE;
    }
    
}
