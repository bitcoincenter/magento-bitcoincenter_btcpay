<?php
class Bitcoincenter_Btcpay_Model_Currency 
{
  public function toOptionArray()
  {
    return array(
      array('value' => 'usd', 'label' =>'US Dollar (usd)'),
      array('value' => 'eur', 'label' => 'Euro (eur)'),
      array('value' => 'jpy', 'label' => 'Jap. yen (eur)'),
      array('value' => 'other', 'label' => 'other - need to specify rate manually'),
      
     // and so on...
    );
  }
}
