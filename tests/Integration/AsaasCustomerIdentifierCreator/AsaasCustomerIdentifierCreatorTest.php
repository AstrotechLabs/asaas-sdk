<?php

declare(strict_types=1);

namespace Tests\Integration\AsaasCustomerIdentifierCreator;

use Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\AsaasCustomerIdentifierCreator;
use Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\Dto\AsaasCustomerData;
use Tests\TestCase;

final class AsaasCustomerIdentifierCreatorTest extends TestCase
{
    public function testItShouldCreateCustomerUniqueIdentifier()
    {
        $customerId = self::$faker->uuid;

        $sut = new AsaasCustomerIdentifierCreator($_ENV['ASAAS_API_KEY'], true);

        $customerAsaasId = $sut->generateCustomerIdentifier(new AsaasCustomerData(
            name: self::$faker->name,
            phone: self::$faker->phoneNumber,
            cpfCnpj: self::$faker->numerify('67981499011'),
            email: self::$faker->email,
            postalCode: self::$faker->postcode,
            address: self::$faker->address,
            addressNumber: self::$faker->randomNumber(2),
            complement: self::$faker->streetAddress,
            province: self::$faker->address,
            externalReference: $customerId,
            notificationDisabled: false,
            additionalEmails: '',
            municipalInscription: '',
            stateInscription: '',
            observations: ''
        ));

        $this->assertNotEmpty($customerAsaasId->identifier);
        $this->assertStringContainsString('cus_', $customerAsaasId->identifier);
    }

    public function testItShouldCreateCustomerUniqueIdentifierWhenProvideOnlyRequiredParameters()
    {
        $sut = new AsaasCustomerIdentifierCreator($_ENV['ASAAS_API_KEY'], true);

        $customerAsaasId = $sut->generateCustomerIdentifier(new AsaasCustomerData(
            name: self::$faker->name,
            phone: self::$faker->phoneNumber,
            cpfCnpj: self::$faker->numerify('67981499011')
        ));

        $this->assertNotEmpty($customerAsaasId->identifier);
        $this->assertStringContainsString('cus_', $customerAsaasId->identifier);
    }
}
