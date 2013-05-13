<?php
 
class Bitcoincenter_Btcpay_Model_Btcpay extends Mage_Core_Model_Abstract
{
	
    public function _construct()
    {
        parent::_construct();
       
        $this->_init('btcpay/btcpay');
    }
}
