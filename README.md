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

```php
use AstrotechLabs\AsaasSdk\AssasGateway;
use AstrotechLabs\AsaasSdk\Enum\BillingTypes;
use AstrotechLabs\AsaasSdk\AssasGatewayParams;
use AstrotechLabs\AsaasSdk\CreatePixCharge\Dto\PixData;

$asaasGateway = new AssasGateway(new AssasGatewayParams(
    apiKey: 'xxxxxxxxxx',
    // isSandBox: true (opcional)
));

$pixChargeResponse = $asaasGateway->createCharge(new PixData(
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

## Contributing

Pull Request são bem-vindas. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.
