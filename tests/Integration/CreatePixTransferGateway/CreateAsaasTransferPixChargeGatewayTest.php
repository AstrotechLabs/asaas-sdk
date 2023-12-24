<?php

declare(strict_types=1);

namespace CreatePixTransferGateway;

use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\CreateTransferChargeGateway;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto\TransferData;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Exceptions\CreateTransferChargeException;
use AstrotechLabs\AsaasSdk\Transfer\Enum\PixKeyTypes;
use Tests\TestCase;

final class CreateAsaasTransferPixChargeGatewayTest extends TestCase
{
    public function testItShouldDefineCorrectUrlWhenNotInSandbox()
    {
        $sut = new CreateTransferChargeGateway($_ENV['ASAAS_API_KEY'], false);

        $this->assertIsString($sut->getBaseUrl());
        $this->assertNotEmpty($sut->getBaseUrl());
        $this->assertSame('https://www.asaas.com/api/v3/', $sut->getBaseUrl());
    }

    public function testItShouldDefineCorrectUrlWhenAsInSandbox()
    {
        $sut = new CreateTransferChargeGateway($_ENV['ASAAS_API_KEY'], true);

        $this->assertIsString($sut->getBaseUrl());
        $this->assertNotEmpty($sut->getBaseUrl());
        $this->assertSame('https://sandbox.asaas.com/api/v3/', $sut->getBaseUrl());
    }

    private function makeSut(): CreateTransferChargeGateway
    {
        return new CreateTransferChargeGateway($_ENV['ASAAS_API_KEY'], true);
    }

    public function testItShouldCreateTransferChargeWithMinimumProvided()
    {
        $sut = $this->makeSut();

        $response = $sut->createCharge(new TransferData(
            value: 200,
            pixAddressKey: 'c39ab866-b4f0-4646-a931-b09d892b1c46',
            pixAddressKeyType: PixKeyTypes::RANDOM_KEY
        ));

        $this->assertIsObject($response);
        $this->assertNotEmpty($response->gatewayId);
        $this->assertNotEmpty($response->status);
        $this->assertSame(0.0, $response->fee);
        $this->assertNotEmpty($response->value);
        $this->assertIsBool($response->authorized);
        $this->assertNotEmpty($response->details);
        $this->assertIsArray($response->details);
        $this->assertArrayHasKey('id', $response->details);
        $this->assertArrayHasKey('status', $response->details);
        $this->assertArrayHasKey('transferFee', $response->details);
        $this->assertArrayHasKey('value', $response->details);
        $this->assertArrayHasKey('authorized', $response->details);
        $this->assertSame($response->gatewayId, $response->details['id']);
        $this->assertSame($response->status, $response->details['status']);
        $this->assertSame((float)$response->fee, (float)$response->details['transferFee']);
        $this->assertSame($response->value, $response->details['value']);
        $this->assertSame($response->authorized, $response->details['authorized']);
    }

    public function testItShouldThrowAnExceptionWhenTryCreateNewChargeWhenBeforeCreatedNotHasCompleted()
    {
        $this->expectException(CreateTransferChargeException::class);
        $this->expectExceptionCode(1001);

        $sut = $this->makeSut();

        $response = $sut->createCharge(new TransferData(
            value: 200,
            pixAddressKey: 'c39ab866-b4f0-4646-a931-b09d892b1c46',
            pixAddressKeyType: PixKeyTypes::RANDOM_KEY
        ));
    }

    public function testItShouldThrowAnExceptionWhenNotProvideValidPixAddressKeyValue()
    {
        $this->expectException(CreateTransferChargeException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Necessário informar uma chave Pix válida.');

        $sut = $this->makeSut();

        $response = $sut->createCharge(new TransferData(
            value: 0,
            pixAddressKey: 'abcde',
            pixAddressKeyType: PixKeyTypes::RANDOM_KEY
        ));
    }
}
