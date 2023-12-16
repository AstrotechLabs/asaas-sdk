<?php

declare(strict_types=1);

namespace Tests\Integration\CreatePixChargeGateway;

use Tests\TestCase;
use AstrotechLabs\AsaasSdk\Enum\BillingTypes;
use AstrotechLabs\AsaasSdk\CreatePixCharge\Dto\PixData;
use AstrotechLabs\AsaasSdk\CreatePixCharge\Dto\QrCodeOutput;
use AstrotechLabs\AsaasSdk\CreatePixCharge\CreatePixChargeGateway;
use AstrotechLabs\AsaasSdk\CreatePixCharge\Exceptions\CreatePixChargeException;

final class CreateAsaasPixChargeGatewayTest extends TestCase
{
    public function testItShouldDefineCorrectUrlWhenNotInSandbox()
    {
        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], false);

        $this->assertIsString($sut->getBaseUrl());
        $this->assertNotEmpty($sut->getBaseUrl());
        $this->assertSame('https://www.asaas.com/api/v3/', $sut->getBaseUrl());
    }

    public function testItShouldDefineCorrectUrlWhenasInSandbox()
    {
        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);

        $this->assertIsString($sut->getBaseUrl());
        $this->assertNotEmpty($sut->getBaseUrl());
        $this->assertSame('https://sandbox.asaas.com/api/v3/', $sut->getBaseUrl());
    }

    public function testItShouldThrowAnExceptionWhenProvideInvalidCustomerIdentifier()
    {
        $this->expectException(CreatePixChargeException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Customer inválido ou não informado.');

        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);
        $customerIdentifier = self::$faker->uuid;

        $response = $sut->createCharge(new PixData(
            customer: $customerIdentifier,
            billingType: BillingTypes::PIX,
            value: 100.90,
            dueDate: "2023-12-20"
        ));
    }

    public function testItShouldThrowAnExceptionWhenProvideInvalidDueDate()
    {
        $this->expectException(CreatePixChargeException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Não é permitido data de vencimento inferior a hoje.');

        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);
        $customerIdentifier = 'cus_000005797885';

        $response = $sut->createCharge(new PixData(
            customer: $customerIdentifier,
            billingType: BillingTypes::PIX,
            value: 100.90,
            dueDate: "2023-07-20"
        ));
    }

    public function testItShouldCreatePaymentCharge()
    {
        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);

        $customerIdentifier = 'cus_000005797885';

        $response = $sut->createCharge(new PixData(
            customer: $customerIdentifier,
            billingType: BillingTypes::PIX,
            value: 100.90,
            dueDate: "2023-12-20"
        ));

        $this->assertIsObject($response);
        $this->assertNotEmpty($response->gatewayId);
        $this->assertNotEmpty($response->paymentUrl);
        $this->assertNotEmpty($response->details);
        $this->assertNotEmpty($response->qrCode);
        $this->assertIsArray($response->details);
        $this->assertArrayHasKey('id', $response->details);
        $this->assertArrayHasKey('customer', $response->details);
        $this->assertArrayHasKey('invoiceUrl', $response->details);
        $this->assertArrayHasKey('value', $response->details);
        $this->assertArrayHasKey('status', $response->details);
        $this->assertSame($response->gatewayId, $response->details['id']);
        $this->assertSame($response->paymentUrl, $response->details['invoiceUrl']);
        $this->assertSame($customerIdentifier, $response->details['customer']);
    }

    public function testItShouldThrowAnExceptionWhenTryGetQrCodeForInvalidOrNonExistentPayment()
    {
        $this->expectException(CreatePixChargeException::class);
        $this->expectExceptionCode(404);

        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);

        $response = $sut->getPaymentQrCode(self::$faker->name);
    }

    public function testItShouldTReturnValidQrCodeWhenValidPaymentIdProvide()
    {
        $sut = new CreatePixChargeGateway($_ENV['ASAAS_API_KEY'], true);

        $response = $sut->getPaymentQrCode('pay_5xs951pgtcuiqe41');

        $this->assertInstanceOf(QrCodeOutput::class, $response);
        $this->assertNotEmpty($response->encodedImage);
        $this->assertNotEmpty($response->copyAndPaste);
        $this->assertNotEmpty($response->expirationDate);
        $this->assertIsString($response->encodedImage);
        $this->assertIsString($response->expirationDate);
        $this->assertIsString($response->copyAndPaste);
    }

}
