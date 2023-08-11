<?php

namespace Give\PaymentGateways\PayPalCommerce\Banners;

/**
 * Class GatewaySettingPageBanner
 *
 * @unreleased
 */
class PayPalDonationsSettingPageBanner
{
    /**
     * @unreleased
     */
    public function render(): string
    {
        return sprintf(
            '<div class="give-paypal-migration-banner paypal-donations-setting-page">
                <p class="message">
                    <span class="icon">%1$s</span>%2$s <a href="%3$s">%4$s</a>
                <p>
            </div>',
            $this->getIcon(),
            esc_html__(
                'Make sure you enable PayPal Donation in the gateway settings to receive payment on your form.',
                'give'
            ),
            esc_url(admin_url('edit.php?post_type=give_forms&page=give-settings&tab=gateways')),
            esc_html__('Go to gateway settings', 'give')
        );
    }

    /**
     * @unreleased
     * @return string
     */
    private function getIcon()
    {
        return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.54172 1.11224C8.19684 0.958885 7.80313 0.958885 7.45825 1.11224C7.1919 1.23067 7.01888 1.43928 6.89848 1.60927C6.7801 1.77639 6.65336 1.99534 6.51398 2.23614L1.00254 11.7559C0.862603 11.9976 0.735434 12.2172 0.649206 12.4036C0.561573 12.593 0.466504 12.8476 0.496803 13.1382C0.53601 13.5143 0.733037 13.856 1.03885 14.0784C1.27518 14.2502 1.54317 14.2955 1.75101 14.3146C1.95551 14.3334 2.20929 14.3333 2.48854 14.3333H13.5114C13.7907 14.3333 14.0445 14.3334 14.249 14.3146C14.4568 14.2955 14.7248 14.2502 14.9611 14.0784C15.2669 13.856 15.464 13.5143 15.5032 13.1382C15.5335 12.8476 15.4384 12.593 15.3508 12.4036C15.2645 12.2172 15.1374 11.9976 14.9975 11.7559L9.48598 2.23611C9.3466 1.99533 9.21986 1.77638 9.10149 1.60927C8.98109 1.43928 8.80807 1.23067 8.54172 1.11224ZM8.66667 5.99999C8.66667 5.6318 8.36819 5.33332 8 5.33332C7.63181 5.33332 7.33334 5.6318 7.33334 5.99999V8.66666C7.33334 9.03485 7.63181 9.33332 8 9.33332C8.36819 9.33332 8.66667 9.03485 8.66667 8.66666V5.99999ZM8 10.6667C7.63181 10.6667 7.33334 10.9651 7.33334 11.3333C7.33334 11.7015 7.63181 12 8 12H8.00667C8.37486 12 8.67334 11.7015 8.67334 11.3333C8.67334 10.9651 8.37486 10.6667 8.00667 10.6667H8Z" fill="#594B05"/>
</svg>
';
    }
}
