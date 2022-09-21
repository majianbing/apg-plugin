<?php
/**
 * E: sales@gloprocessor.com
 * W:www.magento.con
 */
class Magento91_Apgpay_Model_Mysql4_Api_Debug extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('apgpay/api_debug', 'debug_id');
    }
}