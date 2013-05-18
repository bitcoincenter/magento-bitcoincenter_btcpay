<?php
/**
 *
 * @category    Bitcoincenter
 * @package     Bitcoincenter_Btcpay
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bitcoincenter_Btcpay_BtcpayController extends Mage_Checkout_Controller_Action
{
    public function indexAction()
    {
		//success page
		
		 $session = Mage::getSingleton('checkout/type_onepage');
        $quote_id = $this->getRequest()->getParam('quote_id');
        $satoshi = $this->getRequest()->getParam('satoshi');
        Mage::log('quote_id:'.$satoshi);
        $lastOrderId = $session->getLastOrderId($quote_id);
        $btc = Mage::getModel('btcpay/btcpay')->load($quote_id);
        //$session->clear();
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::log('satoshi: '.$satoshi);
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId), 'btc' => $btc->getAddress(), 'satoshi' => $satoshi));
        $this->renderLayout();
    }
    
    public function reportAction(){
		// report
		$api_url = Mage::getStoreConfig('payment/bitcoincenter/apiurl');
		$paid_status = Mage::getStoreConfig('payment/bitcoincenter/paid_status');
		$quote_id = $this->getRequest()->getParam('quote');
		
		$btc = Mage::getModel('btcpay/btcpay')->load($quote_id);
		
		
		$client = new Zend_Rest_Client();
		$client->setUri($api_url.'?function=check_payment&address='.$btc->getAddress());
		$is_paid = $client->get()->is_paid;
		$is_paid=1;
		if( $is_paid == 1) {
			
			// capture payment
			$order = Mage::getModel('sales/order')->loadByAttribute('quote_id',$quote_id);
			$order->getPayment()->registerCaptureNotification($order->getBaseGrandTotal());
            $order->getPayment()->setTransactionId($paymentId);
            $order->setStatus($paid_status)->save();			// this is crappy, isnt it? I dont know how to capture
            $order->save();
		} else {
			// do nothing
		}
		// redirect to 404
		$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
		$this->getResponse()->setHeader('Status','404 File not found');
		$this->_forward('defaultNoRoute');
		
	}
}
