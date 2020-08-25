<?php

namespace FondOfSpryker\Client\CanceledPayment\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;

class CheckoutConfirmedPreCheckTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $quoteTransferMock;

    /**
     * @var \FondOfSpryker\Client\CanceledPayment\Plugin\CheckoutExtension\CheckoutConfirmedPreCheckPlugin
     */
    private $checkoutConfirmPreCheck;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
                                    ->onlyMethods(['getCheckoutConfirmed', 'getOrderReference', 'getIdSalesOrder'])
                                    ->getMock();
        $this->checkoutConfirmPreCheck = new CheckoutConfirmedPreCheckPlugin();
    }

    /**
     * @return void
     */
    public function testOrderPlaced(): void
    {
        $this->quoteTransferMock->method('getOrderReference')->willReturn('abc');
        $this->quoteTransferMock->method('getIdSalesOrder')->willReturn('1234');

        $response = $this->checkoutConfirmPreCheck->isValid($this->quoteTransferMock);

        $this->assertEquals(false, $response->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testOrderNotPlaced(): void
    {
        $this->quoteTransferMock->method('getOrderReference')->willReturn(null);
        $this->quoteTransferMock->method('getIdSalesOrder')->willReturn(null);

        $response = $this->checkoutConfirmPreCheck->isValid($this->quoteTransferMock);

        $this->assertEquals(true, $response->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testErrorMessage(): void
    {
        $this->quoteTransferMock->method('getCheckoutConfirmed')->willReturn(false);
        $response = $this->checkoutConfirmPreCheck->isValid($this->quoteTransferMock);

        $messages = $response->getMessages();
        $this->assertEquals('error', $messages[0]->getType());
        $this->assertEquals('checkout.error.already_confirmed', $messages[0]->getValue());
    }
}
