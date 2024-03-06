<?php

namespace common\components;

use Fifa\ConnectServiceBus\Sdk\FifaConnectServiceBusClient;
use Fifa\ConnectServiceBus\Sdk\Authentication\Model\ClientCredentials;
use Fifa\ConnectServiceBus\Sdk\Encryption\Decrypt\PrivateCertificateMemoryStorage;
use Fifa\ConnectServiceBus\Sdk\Encryption\Model\PrivateCertificate;
use Fifa\ConnectServiceBus\Sdk\Environment\Environment;
use Fifa\ConnectServiceBus\Sdk\Utils\File;

class SdkComponent
{
    public static function createInstance($clientId, $secretKey, $filePath)
    {
        $clientCredentials = new ClientCredentials($clientId, $secretKey);
        $privateCertificate = new PrivateCertificate(File::getContents($filePath), 'Test123');
        $privateStore = new PrivateCertificateMemoryStorage($privateCertificate);
        $logger = new YourOwnLogger(); // Используем ваш регистратор
        $envCode = 'testenv';
        $environment = Environment::create($envCode);
        return FifaConnectServiceBusClient::create(Environment::Beta(), $clientCredentials, $privateStore, $logger);
    }
}
