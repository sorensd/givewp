<?php

namespace Give\PaymentGateways;

use Give\Framework\PaymentGateways\PaymentGatewayRegister;
use Give\Framework\PaymentGateways\Routes\GatewayRoute;
use Give\Helpers\Hooks;
use Give\LegacyPaymentGateways\Actions\RegisterPaymentGatewaySettingsList;
use Give\PaymentGateways\Actions\RegisterPaymentGateways;
use Give\PaymentGateways\PayPalStandard\Controllers\PayPalStandardWebhook;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;

/**
 * Class ServiceProvider - PaymentGateways
 *
 * The Service Provider for loading the Payment Gateways for Payment Flow 2.0
 *
 * @since 2.18.0
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        give()->singleton(PaymentGatewayRegister::class);
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        Hooks::addFilter('give_register_gateway', RegisterPaymentGateways::class);
        Hooks::addFilter('give_payment_gateways', RegisterPaymentGatewaySettingsList::class);
        Hooks::addAction('template_redirect', GatewayRoute::class);

        // We are adding event listener to this action hook.
        // This hook fires for PayPal Standard ipn for onetime donation.
        Hooks::addAction(
            'give_paypal_web_accept',
            PayPalStandardWebhook::class,
            'handleIpnForOneTimeDonation',
            10,
            2
        );
    }
}
