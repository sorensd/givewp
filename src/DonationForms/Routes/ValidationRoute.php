<?php

namespace Give\DonationForms\Routes;


use Give\DonationForms\DataTransferObjects\DonateRouteData;
use Give\DonationForms\DataTransferObjects\ValidationRouteData;
use Give\DonationForms\Exceptions\DonationFormFieldErrorsException;
use Give\Framework\PaymentGateways\Traits\HandleHttpResponses;
use Give\Log\Log;
use WP_Error;

/**
 * @unreleased
 */
class ValidationRoute
{
    use HandleHttpResponses;

    /**
     * @unreleased
     */
    public function __invoke(array $request): bool
    {
        // create DTO from GET request
        $routeData = DonateRouteData::fromRequest(give_clean($_GET));

        // validate signature
        $routeData->validateSignature();

        // create DTO from POST request
        $formData = ValidationRouteData::fromRequest($request);

        try {
            $response = $formData->validate();
            
            $this->handleResponse($response);
        } catch (DonationFormFieldErrorsException $exception) {
            $type = 'validation_error';
            $this->logError($type, $exception->getMessage(), $formData);
            $this->sendJsonError($type, $exception->getError());
        }

        exit;
    }

    /**
     * @unreleased
     */
    private function logError(
        string $type,
        string $exceptionMessage,
        ValidationRouteData $formData
    ) {
        Log::error(
            "Donation Route Error: $type",
            [
                'error_type' => $type,
                'exceptionMessage' => $exceptionMessage,
                'formData' => $formData->toArray(),
            ]
        );
    }

    /**
     * @param  string  $type
     * @param  array|string|WP_Error  $errors
     * @return void
     */
    protected function sendJsonError(string $type, WP_Error $errors)
    {
        wp_send_json_error([
            'type' => $type,
            'errors' => $errors,
        ]);
    }
}
