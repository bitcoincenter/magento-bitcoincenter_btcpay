<?php
 
class Bitcoincenter_Btcpay_Model_Mysql4_Btcpay_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('btcpay/btcpay');
    }
}
