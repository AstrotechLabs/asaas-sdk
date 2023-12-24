# Assas Pay SDK para PHP

Este é um repositório que possui uma abstração a API do Asaas V3, facilitando a criação de PIX Copia e Cola como também outros serviços oferecidos

## Instalação

A forma mais recomendada de instalar este pacote é através do [composer](http://getcomposer.org/download/).

Para instalar, basta executar o comando abaixo

```bash
$ php composer.phar require astrotechlabs/asaas-sdk
```

ou adicionar esse linha

```
"astrotechlabs/asaas-sdk": "^1.0"
```

na seção `require` do seu arquivo `composer.json`.

## COMO USAR?

## Criação de um depósito via PIX
Com o código abaixo você consegue fazer a criação de uma cobrança via PIX, onde serão retornadas os dados da **Chave Pix Cópia/Cola** (`copyPasteUrl`) como também já é retornado um **QRCode em base64** (`qrCode`) para você disponibilizar para o frontend da sua aplicação.

```php
use AstrotechLabs\AsaasSdk\AssasGateway;
use AstrotechLabs\AsaasSdk\AssasGatewayParams;
use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto\PixData;
use AstrotechLabs\AsaasSdk\Pix\Enum\BillingTypes;

$asaasGateway = new AssasGateway(new AssasGatewayParams(
    apiKey: 'xxxxxxxxxx',
    // isSandBox: true (opcional)
));

$pixChargeResponse = $asaasGateway->createPixCharge(new PixData(
    customer: new CustomerData(
        name: 'Joãozinho Barbosa',
        phone: '999999999',
        cpfCnpj: '01234567890'
    ),
    billingType: BillingTypes::PIX,
    value: 100.00,
    dueDate: "2023-12-20" // Deve ser informada uma data futura
));

print_r($pixChargeResponse);
```

### Saída
```
[
    'gatewayId': 'pay_kp6gqaovguxqr1od',
    'paymentUrl': 'https://sandbox.asaas.com/i/kp6gqaovguxqr1od',
    'copyPasteUrl': '00020101021226820014br.gov.bcb.pix2560qrpix-h.bradesco.com.br/xxxxxxxxx-xxxx......',
    'details' => [
        'object' => 'payment'
        'id' => 'pay_kp6gqaovguxqr1od'
        'dateCreated' => '2023-12-16'
        'customer' => 'cus_000005797885'
        'paymentLink' => 'https://sandbox.asaas.com/i/xxxxxxxxxxx',
        ..............
    ],
    'qrCode' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAYsAAA......'
]
```

### Webhook
Quando é confirmada a transação via PIX o payload JSON abaixo é enviado para sua aplicação pela URL configurada no Backoffice do Asaas.

```json
{
   "event":"PAYMENT_RECEIVED",
   "payment":{
      "object":"payment",
      "id":"pay_080225913252",
      "dateCreated":"2021-01-01",
      "customer":"cus_G7Dvo4iphUNk",
      "subscription":"sub_VXJBYgP2u0eO",  
      "installment":"2765d086-c7c5-5cca-898a-4262d212587c",
      "paymentLink":"123517639363",
      "dueDate":"2021-01-01",
      "originalDueDate":"2021-01-01",
      "value":100,
      "netValue":94.51,
      "originalValue":null,
      "interestValue":null,
      "nossoNumero": null,
      "description":"Pedido 056984",
      "externalReference":"056984",
      "billingType":"CREDIT_CARD",
      "status":"RECEIVED",
      "pixTransaction":null,
      "confirmedDate":"2021-01-01",
      "paymentDate":"2021-01-01",
      "clientPaymentDate":"2021-01-01",
      "installmentNumber": null,
      "creditDate":"2021-02-01",
      "custody": null,
      "estimatedCreditDate":"2021-02-01",
      "invoiceUrl":"https://www.asaas.com/i/080225913252",
      "bankSlipUrl":null,
      "transactionReceiptUrl":"https://www.asaas.com/comprovantes/4937311816045162",
      "invoiceNumber":"00005101",
      "deleted":false,
      "anticipated":false,
      "anticipable":false,
      "lastInvoiceViewedDate":"2021-01-01 12:54:56",
      "lastBankSlipViewedDate":null,
      "postalService":false,
      "creditCard":{
         "creditCardNumber":"8829",
         "creditCardBrand":"MASTERCARD",
         "creditCardToken":"a75a1d98-c52d-4a6b-a413-71e00b193c99"
      },
      "discount":{
         "value":0.00,
         "dueDateLimitDays":0,
         "limitedDate": null,
         "type":"FIXED"
      },
      "fine":{
         "value":0.00,
         "type":"FIXED"
      },
      "interest":{
         "value":0.00,
         "type":"PERCENTAGE"
      },
      "split":[
         {
            "walletId":"48548710-9baa-4ec1-a11f-9010193527c6",
            "fixedValue":20,
            "status":"PENDING",
            "refusalReason": null
         },
         {
            "walletId":"0b763922-aa88-4cbe-a567-e3fe8511fa06",
            "percentualValue":10,
            "status":"PENDING",
            "refusalReason": null
         }
      ],
      "chargeback": {
          "status": "REQUESTED",
          "reason": "PROCESS_ERROR"
      },
      "refunds": null
   }
}
```

Para mais detalhes sobre o webhook veja a [documentação aqui.](https://docs.asaas.com/docs/webhook-para-cobrancas)

## Criação de uma transferência
Com o código abaixo você consegue fazer a criação de uma transferência via **PIX**

```php
use AstrotechLabs\AsaasSdk\AssasGateway;
use AstrotechLabs\AsaasSdk\AssasGatewayParams;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto\TransferData;
use AstrotechLabs\AsaasSdk\Transfer\Enum\PixKeyTypes;

$asaasGateway = new AssasGateway(new AssasGatewayParams(
    apiKey: $_ENV['ASAAS_API_KEY'],
    isSandBox: false
));

$transferChargeResponse = $asaasGateway->createTransferCharge(new TransferData(
    value: 1,
    pixAddressKey: 'xxxxxxxx-xxxxx-xxxxx-xxxx',
    pixAddressKeyType: PixKeyTypes::RANDOM_KEY
));

print_r($transferChargeResponse);
```

### Saída
```
[
    'gatewayId' => 'fb408225-8d98-4afe-b193-894cbdf1db55'
    'status' => 'PENDING'
    'fee' => 0
    'value' => 1
    'authorized' => false
    'details' => [
        'object' => 'transfer'
        'id' => 'fb408225-8d98-4afe-b193-894cbdf1db55'
        'value' => 1.0,
        ........
    ]
]
```

### Webhook
Quando é confirmada a transação via de transferência o payload JSON abaixo é enviado para sua aplicação pela URL configurada no Backoffice do Asaas.

```json
{
    "event": "TRANSFER_CREATED",
    "transfer": {
        "object": "transfer",
        "id": "777eb7c8-b1a2-4356-8fd8-a1b0644b5282",
        "dateCreated": "2019-05-02",
        "status": "PENDING",
        "effectiveDate": null,
        "endToEndIdentifier": null,
        "type": "BANK_ACCOUNT",
        "value": 1000,
        "netValue": 1000,
        "transferFee": 0,
        "scheduleDate": "2019-05-02",
        "authorized": true,
        "failReason": null,
        "transactionReceiptUrl": null,
        "bankAccount": {
            "bank": {
                "ispb": "00000000",
                "code": "001",
                "name": "Banco do Brasil"
            },
            "accountName": "Conta Banco do Brasil",
            "ownerName": "Marcelo Almeida",
            "cpfCnpj": "***.143.689-**",
            "agency": "1263",
            "agencyDigit": "1",
            "account": "26544",
            "accountDigit": "1",
            "pixAddressKey": null
        },
        "operationType": "TED",
        "description": null
    }
}
```

Para mais detalhes sobre o webhook veja a [documentação aqui.](https://docs.asaas.com/docs/webhook-para-transferencias)

## Contribuição

Pull Request são bem-vindas. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licença

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.
