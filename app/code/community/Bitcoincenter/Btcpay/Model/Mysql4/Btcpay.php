<?php
/**
 * @category    Bitcoincenter
 * @package     Bitcoincenter_Btcpay
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bitcoincenter_Btcpay_Model_Mysql4_Btcpay extends Mage_Core_Model_Mysql4_Abstract
{
	protected $_isPkAutoIncrement = false;
    public function _construct()
    {
        //parent::_construct();
        $this->_init('btcpay/btcpay', 'quote_id');
    }
}
