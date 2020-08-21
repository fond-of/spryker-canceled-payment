# Spryker Canceled Payment

This plugin helps to mitigate errors which occur when customer cancel during external checkout.
For example Paypal or 3d-secure. Currently it contains a plugin which will set an error whenever the checkout has
 been already confiremd.

## Installation

`composer require fond-of-spryker/canceled-payment`

**Register:**
`src/Pyz/Client/Checkout/CheckoutDependencyProvider.php`

```php
<?php

namespace Pyz\Client\Checkout;

use FondOfSpryker\Client\CanceledPayment\Plugin\CheckoutExtension\CheckoutConfirmedPreCheck;
use Spryker\Client\Checkout\CheckoutDependencyProvider as SprykerCheckoutDependencyProvider;

class CheckoutDependencyProvider extends SprykerCheckoutDependencyProvider
{

    ...

    /**
     * @return \Spryker\Client\CheckoutExtension\Dependency\Plugin\CheckoutPreCheckPluginInterface[]
     */
    protected function getCheckoutPreCheckPlugins(): array
    {
        return [
            new CheckoutConfirmedPreCheck(),
        ];
    }

    ...

}

```
