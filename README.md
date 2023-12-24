# Assas Pay SDK para PHP

Este é um repositório que possui uma abstração a API do Asaas, facilitando a criação de PIX Copia e Cola como também outros serviços oferecidos

## Installation

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

## Como Usar?
### Minimo para utilização

### Criação de um deposito (PIX)
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
    dueDate: "2023-12-20"
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

### Criação de uma transferência (PIX)
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


## Contributing

Pull Request são bem-vindas. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.
