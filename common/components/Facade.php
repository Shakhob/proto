<?php

namespace common\components;

use Fifa\ConnectId\Sdk\Environment\Environment;
use Fifa\ConnectId\Sdk\Registration\Model\RegistrationFacadeSettings;
use Fifa\ConnectId\Sdk\Registration\RegistrationFacade;
use Fifa\ConnectId\Sdk\Storage\SqliteStorage;
use Fifa\ConnectServiceBus\Sdk\Authentication\Model\ClientCredentials;
use Fifa\ConnectServiceBus\Sdk\Encryption\Decrypt\PrivateCertificateMemoryStorage;
use Fifa\ConnectServiceBus\Sdk\Encryption\Model\PrivateCertificate;
use frontend\models\MyLogger;
use frontend\models\PersonDetailsProvider;
use Yii;
use Fifa\ConnectId\Sdk\Util\File;

class Facade
{
    private function initializeFacade(): RegistrationFacade {
        $filePath = Yii::getAlias("@frontend") . '/openssl_output/private_key.pem';
        $clientCredentials = new ClientCredentials('78123107-83d3-49e7-8692-05619e06916c', 'iKp8Q~Qg6dRTgx6smhwFyZuKfkOwUCab4NSv5caS');
        $logger = new MyLogger(); // Замените MyLogger на свой класс логгера
        $privateCertificate = new PrivateCertificate(File::getContents($filePath), 'ufaid');
        $privateStorage = new PrivateCertificateMemoryStorage($privateCertificate);
        $useEncryption = false;
        $executionTime = 60;
        $storage = SqliteStorage::getInstance($logger);
        $privateCertificate = new PrivateCertificate(File::getContents($filePath), 'SomePassword');
        $privateStorage = new PrivateCertificateMemoryStorage($privateCertificate);
        $facadeSettings = new RegistrationFacadeSettings($storage, $executionTime, $useEncryption);
        return new RegistrationFacade(Environment::Beta(), $clientCredentials, $privateStorage, $logger, $facadeSettings);
    }

    private function configureEventHandlers(RegistrationFacade $facade) {
        $facade->configureEventHandlers(new PersonDetailsProvider());
    }

}