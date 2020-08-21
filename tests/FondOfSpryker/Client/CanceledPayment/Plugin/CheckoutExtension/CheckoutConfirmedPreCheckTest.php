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
                                    ->onlyMethods(['getCheckoutConfirmed'])
                                    ->getMock();
        $this->checkoutConfirmPreCheck = new CheckoutConfirmedPreCheckPlugin();
    }

    /**
     * @return void
     */
    public function testCheckoutConfirmed(): void
    {
        $this->quoteTransferMock->method('getCheckoutConfirmed')->willReturn(true);
        $response = $this->checkoutConfirmPreCheck->isValid($this->quoteTransferMock);

        $this->assertEquals(false, $response->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testCheckoutNotConfirmed(): void
    {
        $this->quoteTransferMock->method('getCheckoutConfirmed')->willReturn(false);
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
