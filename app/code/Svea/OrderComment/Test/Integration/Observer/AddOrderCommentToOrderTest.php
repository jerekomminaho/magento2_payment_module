<?php
namespace Svea\OrderComment\Test\Integration\Observer;

use Svea\OrderComment\Model\Data\OrderComment;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * Class AddOrderCommentToOrderTest
 * @package Svea\OrderComment\Test\Integration\Observer
 *
 * tests if the comment gets passed from the quote to the order during order creation.
 * @magentoDbIsolation enabled
 */
class AddOrderCommentToOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create order with product that has child items
     *
     * @magentoDataFixture Magento/Sales/_files/quote_with_bundle.php
     * @return void
     */
    public function testExecute()
    {
        $comment = 'test comment';

        $objectManager = Bootstrap::getObjectManager();

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $objectManager->create(\Magento\Quote\Model\Quote::class);
        $quote->load('test01', 'reserved_order_id');

        $quote->setData(OrderComment::COMMENT_FIELD_NAME, $comment);
        $quote->save();
        
        /** @var \Magento\Quote\Api\CartManagementInterface|\Magento\Quote\Model\QuoteManagement $model */
        $model = $objectManager->create(\Magento\Quote\Api\CartManagementInterface::class);
        /** @var \Magento\Sales\Model\Order $order */
        $order = $model->submit($quote);
        
        self::assertEquals($comment, $order->getData(OrderComment::COMMENT_FIELD_NAME));
    }
}
