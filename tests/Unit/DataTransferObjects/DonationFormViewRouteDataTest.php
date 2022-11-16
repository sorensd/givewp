<?php

namespace TestsNextGen\Unit\DataTransferObjects;

use Give\NextGen\DonationForm\DataTransferObjects\DonationFormViewRouteData;
use Give\NextGen\DonationForm\Models\DonationForm;
use GiveTests\TestCase;

/**
 * @unreleased
 */
class DonationFormViewRouteDataTest extends TestCase
{
    /**
     * @unreleased
     *
     * @return void
     */
    public function testShouldReturnFormId()
    {
        $data = DonationFormViewRouteData::fromRequest([
            'form-id' => '1',
            'form-template-id' => 'classic',
        ]);

        $this->assertSame(1, $data->formId);
    }

    /**
     * @unreleased
     *
     * @return void
     */
    public function testShouldReturnFormSettings()
    {
        $data = DonationFormViewRouteData::fromRequest([
            'form-id' => '1',
            'form-settings' => [
                'designId' => 'classic',
            ],
        ]);

        $this->assertSame('classic', $data->formSettings['designId']);
    }

    /**
     * @unreleased
     *
     * @return void
     */
    public function testShouldReturnFormBlocks()
    {
        $data = DonationFormViewRouteData::fromRequest([
            'form-id' => '1',
            'form-template-id' => 'classic',
            'form-blocks' => DonationForm::factory()->definition()['blocks']->toJson(),
        ]);

        $this->assertEquals(DonationForm::factory()->definition()['blocks'], $data->formBlocks);
    }

}
