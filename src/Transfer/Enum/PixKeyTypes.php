<?php

namespace AstrotechLabs\AsaasSdk\Transfer\Enum;

enum PixKeyTypes: string
{
    case CPF = 'CPF';
    case PHONE = 'PHONE';
    case EMAIL = 'EMAIL';
    case RANDOM_KEY = 'EVP';
}
