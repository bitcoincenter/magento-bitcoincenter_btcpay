<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('bitcoincenter_btcpay');

$sql=<<<SQLTEXT
CREATE TABLE `{$tableName}` (
  `quote_id` INT NOT NULL AUTO_INCREMENT ,
  `address` VARCHAR( 64 ) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
PRIMARY KEY ( `quote_id` )
) ENGINE = InnoDB;
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
