<?php

namespace FondOfSpryker\Client\CanceledPayment\Plugin\CheckoutExtension;

use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\QuoteValidationResponseTransfer;
use Spryker\Client\CheckoutExtension\Dependency\Plugin\CheckoutPreCheckPluginInterface;

class CheckoutConfirmedPreCheckPlugin implements CheckoutPreCheckPluginInterface
{
    protected const GLOSSARY_KEY_ERROR_CHECKOUT_ALREADY_CONFIRMED = 'checkout.error.already_confirmed';
    protected const MESSAGE_TYPE_ERROR = 'error';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteValidationResponseTransfer
     */
    public function isValid(QuoteTransfer $quoteTransfer): QuoteValidationResponseTransfer
    {
        $response = new QuoteValidationResponseTransfer();

        $response->setIsSuccessful(
            $quoteTransfer->getCheckoutConfirmed() === false
        )->addMessage(
            (new MessageTransfer())
            ->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::GLOSSARY_KEY_ERROR_CHECKOUT_ALREADY_CONFIRMED)
        );

        return $response;
    }
}
