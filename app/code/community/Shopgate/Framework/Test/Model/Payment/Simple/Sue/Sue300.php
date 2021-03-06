<?php

/**
 * Shopgate GmbH
 *
 * URHEBERRECHTSHINWEIS
 *
 * Dieses Plugin ist urheberrechtlich geschützt. Es darf ausschließlich von Kunden der Shopgate GmbH
 * zum Zwecke der eigenen Kommunikation zwischen dem IT-System des Kunden mit dem IT-System der
 * Shopgate GmbH über www.shopgate.com verwendet werden. Eine darüber hinausgehende Vervielfältigung, Verbreitung,
 * öffentliche Zugänglichmachung, Bearbeitung oder Weitergabe an Dritte ist nur mit unserer vorherigen
 * schriftlichen Zustimmung zulässig. Die Regelungen der §§ 69 d Abs. 2, 3 und 69 e UrhG bleiben hiervon unberührt.
 *
 * COPYRIGHT NOTICE
 *
 * This plugin is the subject of copyright protection. It is only for the use of Shopgate GmbH customers,
 * for the purpose of facilitating communication between the IT system of the customer and the IT system
 * of Shopgate GmbH via www.shopgate.com. Any reproduction, dissemination, public propagation, processing or
 * transfer to third parties is only permitted where we previously consented thereto in writing. The provisions
 * of paragraph 69 d, sub-paragraphs 2, 3 and paragraph 69, sub-paragraph e of the German Copyright Act shall remain unaffected.
 *
 * @author             Shopgate GmbH <interfaces@shopgate.com>
 * @author             Konstantin Kiritsenko <konstantin.kiritsenko@shopgate.com>
 * @group              Shopgate_Payment
 * @group              Shopgate_Payment_Sue
 *
 * @coversDefaultClass Shopgate_Framework_Model_Payment_Simple_Sue_Sue300
 */
class Shopgate_Framework_Test_Model_Payment_Simple_Sue_Sue300 extends Shopgate_Framework_Test_Model_Payment_Abstract
{
    const MODULE_CONFIG      = 'Paymentnetwork_Pnsofortueberweisung';
    const CLASS_SHORT_NAME   = 'shopgate/payment_simple_sue_sue300';
    const XML_CONFIG_ENABLED = 'payment/paymentnetwork_pnsofortueberweisung/active';

    /** @var Shopgate_Framework_Model_Payment_Simple_Sue_Sue300 $class */
    protected $class;

    /**
     * Custom rewrite for when status is paid
     *
     * @param string $state - magento order state
     *
     * @uses         ShopgateOrder::setIsPaid
     * @uses         Shopgate_Framework_Model_Payment_Simple_Sue_Sue300::getShopgateOrder
     * @uses         Shopgate_Framework_Test_Model_Payment_Abstract::setPaidStatusFixture
     * @covers       ::setOrderStatus
     *
     * @dataProvider allStateProvider
     */
    public function testSetOrderStatus($state)
    {
        $this->class->getShopgateOrder()->setIsPaid(1);

        $this->setPaidStatusFixture($state);
        $order = Mage::getModel('sales/order');
        $this->class->setOrderStatus($order);

        //todo-sg: mock it up
        if (!$order->getShopgateStatusSet()) {
            $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        }

        $this->assertEquals($state, $order->getState());
    }

    /**
     * Custom rewrite for when status is not paid
     *
     * @param string $state - magento order state
     *
     * @uses         ShopgateOrder::setIsPaid
     * @uses         Shopgate_Framework_Model_Payment_Simple_Sue_Sue300::getShopgateOrder
     * @uses         Shopgate_Framework_Test_Model_Payment_Abstract::setNotPaidStatusFixture
     * @covers       ::setOrderStatus
     * 
     * @dataProvider allStateProvider
     */
    public function testNotPaidStatus($state)
    {
        $this->class->getShopgateOrder()->setIsPaid(0);

        $this->setNotPaidStatusFixture($state);
        $order = Mage::getModel('sales/order');
        $this->class->setOrderStatus($order);

        //todo-sg: mock it up
        if (!$order->getShopgateStatusSet()) {
            $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        }

        $this->assertEquals($state, $order->getState());
    }
}