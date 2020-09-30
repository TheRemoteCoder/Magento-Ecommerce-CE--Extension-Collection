<?php
/**
 * Class TheRemoteCoder_PaymentFree_Model_PaymentFree
 */
class TheRemoteCoder_PaymentFree_Model_PaymentFree extends Mage_Payment_Model_Method_Abstract
{
    /** @var string */
    protected $_code = 'paymentfree';


    // ---------------------------------------------------------------------------------------------------------- Public

    /**
     * Override availability check for this payment method.
     * Limit availability by customer group.
     *
     * @see    parent::isAvailable()
     * @param  Mage_Sales_Model_Quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        //Mage::log(__CLASS__ . '->' . __FUNCTION__);

        if (   $this->getIsActiveExtension()
            && $this->getIsAllowedCustomerGroup()) {
            //Mage::log('Extension is active and customer group correct.');
            return true;
        }

        //Mage::log('Extension is disabled or wrong customer group.');
        return false;
    }


    // --------------------------------------------------------------------------------------------------------- Private

    /**
     * Get if extension is enabled from its admin config.
     * Convert string integers to boolean value.
     *
     * @return boolean
     */
    private function getIsActiveExtension()
    {
        //Mage::log(__CLASS__ . '->' . __FUNCTION__);
        //Mage::log('Is active?: ' . $this->getConfigData('active'));
        return (boolean)$this->getConfigData('active');
    }

    /**
     * Customer must be logged in and in allowed groups to use this method.
     * The customer group is a required admin field that cannot be empty.
     *
     * @return boolean
     */
    private function getIsAllowedCustomerGroup()
    {
        $allowedCustomerGroups = explode(',', (string)$this->getConfigData('customergroup'));

        //Mage::log('Current Customer Group ID: ' . Mage::getSingleton('customer/session')->getCustomer()->getData('group_id'));
        //Mage::log('Allowed Customer Groups: ' . $this->getConfigData('customergroup'));
        //Mage::log(__CLASS__ . '->' . __FUNCTION__);

        if (!count($allowedCustomerGroups)) {
            //Mage::log('customergroup/multiselect field must not be empty.');
            return false;
        }

        if (   empty($allowedCustomerGroups[0])
            && count($allowedCustomerGroups) == 1) {
            //Mage::log('customergroup/multiselect field must not be empty.');
            return false;
        }

        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            //Mage::log('Customer must be logged in.');
            return false;
        }

        $customerGroupId = Mage::getSingleton('customer/session')->getCustomer()->getData('group_id');


        /**
         * This cannot happen. ID is always at least =1.
         * Read the docs for more information.
         */
        if ('0' == (string)$customerGroupId) {
            //Mage::log('Customer is not logged in or has wrong group (should never happen, but ... system error?)');
            return false;
        }

        if (!in_array($customerGroupId, $allowedCustomerGroups)) {
            //Mage::log('Customer is logged in, but not within allowed groups.');
            return false;
        }

        //Mage::log('Customer is logged in and within allowed groups.');
        return true;
    }
}

