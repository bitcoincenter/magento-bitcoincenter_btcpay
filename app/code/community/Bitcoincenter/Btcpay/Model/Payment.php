<?php
/**
 *
 * @category    Bitcoincenter
 * @package     Bitcoincenter_Btcpay
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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
		$api_url = Mage::getStoreConfig('payment/bitcoincenter/apiurl');
		$merchant_code = Mage::getStoreConfig('payment/bitcoincenter/merchantcode');
		$report_url = Mage::helper('core/url')->getHomeUrl().'btcpay/btcpay/report/quote/'.$quote_id;

		$currency = Mage::getStoreConfig('payment/bitcoincenter/currency');
		if ($currency == 'other'){		// there is a rate specified manually
			$rate = Mage::getStoreConfig('payment/bitcoincenter/rate');
			$rate = str_replace(',','.',$rate);
			$amount = $quote->getData('grand_total')/$rate;
			$currency = 'usd';
		} else {
			$amount = $quote->getData('grand_total');
		}

		$client = new Zend_Rest_Client();
		$client->setUri($api_url.'?function=market_value&currency='.$currency.'&amount='.$amount);
		$satoshi = $client->get()->satoshi;
		
		
		$client2 = new Zend_Rest_Client();
		$url = $api_url.'?function=address&amount='.$satoshi.'&merchant_code='.$merchant_code.'&report_url='.urlencode($report_url);
		$client2->setUri($url);
		$address = $client2->get()->address;
		
		
		
		$btcpay = Mage::getModel('btcpay/btcpay');
		$btcpay->setQuoteId($quote_id);
		$btcpay->setAddress($address);
		$btcpay->save();
		
		return Mage::getUrl('btcpay/btcpay/', array('quote_id' => $quote_id, 'satoshi' => ''.$satoshi));
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
