<?php

declare(strict_types=1);

namespace Tests\Integration\CustomerIdentifierCreator;

use AstrotechLabs\AsaasSdk\Pix\CustomerIdentifierCreator\CustomerIdentifierCreator;
use AstrotechLabs\AsaasSdk\Pix\CustomerIdentifierCreator\Dto\CustomerData;
use Tests\TestCase;

final class CustomerIdentifierCreatorTest extends TestCase
{
    public function testItShouldCreateCustomerUniqueIdentifier()
    {
        $customerId = self::$faker->uuid;

        $sut = new CustomerIdentifierCreator($_ENV['ASAAS_API_KEY'], true);

        $customerAsaasId = $sut->generateCustomerIdentifier(new CustomerData(
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
        $sut = new CustomerIdentifierCreator($_ENV['ASAAS_API_KEY'], true);

        $customerAsaasId = $sut->generateCustomerIdentifier(new CustomerData(
            name: self::$faker->name,
            phone: self::$faker->phoneNumber,
            cpfCnpj: self::$faker->numerify('67981499011')
        ));

        $this->assertNotEmpty($customerAsaasId->identifier);
        $this->assertStringContainsString('cus_', $customerAsaasId->identifier);
    }
}
