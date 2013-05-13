<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Bitcoincenter
 * @package     Bitcoincenter_Btcpay
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @generator   http://www.mgt-commerce.com/kickstarter/ Mgt Kickstarter
 */

class Bitcoincenter_Btcpay_BtcpayController extends Mage_Checkout_Controller_Action
{
    public function indexAction()
    {
		Mage::log('in the controller');
		 $session = Mage::getSingleton('checkout/type_onepage');
        $quote_id = $this->getRequest()->getParam('quote_id');
        Mage::log('nu: '.$quote_id);
        $lastOrderId = $session->getLastOrderId($quote_id);
        
        //$session->clear();
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        $this->renderLayout();
    }
}
