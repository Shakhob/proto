<?php

namespace common\models;

use common\components\TestEventHandler;
use Fifa\ConnectId\Sdk\Api\Model\NationalIdentifierType;
use Fifa\ConnectId\Sdk\Api\Model\PersonType;
use Fifa\ConnectId\Sdk\Api\Model\PlayerRegistrationType;
use Fifa\ConnectId\Sdk\Environment\Environment;
use Fifa\ConnectId\Sdk\Exception\XmlDeserializationException;
use Fifa\ConnectId\Sdk\Exception\XmlSerializationException;
use Fifa\ConnectId\Sdk\Model\DataStandard\NationalIdentifier;
use Fifa\ConnectId\Sdk\Model\DataStandard\PersonLocal;
use Fifa\ConnectId\Sdk\Model\DataStandard\Photo;
use Fifa\ConnectId\Sdk\Model\DataStandard\PictureEmbedded;
use Fifa\ConnectId\Sdk\Model\DataStandard\PlayerRegistration;
use Fifa\ConnectId\Sdk\Model\PersonData;
use Fifa\ConnectId\Sdk\Model\PersonName;
use Fifa\ConnectId\Sdk\Registration\Model\RegistrationFacadeSettings;
use Fifa\ConnectId\Sdk\Registration\RegistrationFacade;
use Fifa\ConnectId\Sdk\Storage\SqliteStorage;
use Fifa\ConnectId\Sdk\Util\Data\ClubTrainingCategory;
use Fifa\ConnectId\Sdk\Util\Data\Discipline;
use Fifa\ConnectId\Sdk\Util\Data\Gender;
use Fifa\ConnectId\Sdk\Util\Data\Person\Level;
use Fifa\ConnectId\Sdk\Util\Data\RegistrationNature;
use Fifa\ConnectId\Sdk\Util\Data\Status;
use Fifa\ConnectId\Sdk\Util\File;
use Fifa\ConnectId\Sdk\Util\PersonLocalXmlSerializer\PersonLocalXmlSerializer;
use Fifa\ConnectServiceBus\Sdk\Authentication\Model\ClientCredentials;
use Fifa\ConnectServiceBus\Sdk\Encryption\Decrypt\PrivateCertificateMemoryStorage;
use Fifa\ConnectServiceBus\Sdk\Encryption\Model\PrivateCertificate;
use frontend\models\MyLogger;
use frontend\models\PersonDetailsProvider;
use Yii;

class RegistrationModel {
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
    private function createPersonLocal(): PersonLocal {
        $localLastName = 'ΧΑΡΑΛΑΜΠΟΥΣ';
        $gender = Gender::MALE;
        $nationality = 'CY';
        $dateOfBirth = new \DateTime('1989-05-31', new \DateTimeZone('UTC'));
        $countryOfBirth = 'CY';
        $placeOfBirth = 'Larnaca';
        $localLanguage = 'gre';
        $localCountry = 'CY';
        $personFIFAId = '105C3Z1';

        try {
            return new PersonLocal($localLastName, $gender, $nationality, $dateOfBirth, $countryOfBirth, $placeOfBirth, $localLanguage, $localCountry, $personFIFAId);
        } catch (\Fifa\ConnectId\Sdk\Util\ToString\Exception\ToStringException $e) {
            // Обработка ошибок, если необходимо
        }
    }
    private function createPlayerRegistration(string $personFIFAId): PlayerRegistration {
        $status = Status::ACTIVE;
        $clubOrMemberAssociationId = '105C40I';
        $registrationValidFrom = new \DateTime('2003-04-11', new \DateTimeZone('UTC'));
        $level = strtolower(Level::AMATEUR);
        $discipline = Discipline::FOOTBALL;
        $registrationNature = RegistrationNature::REGISTRATION;

        $playerRegistration = new PlayerRegistration($personFIFAId, $status, $clubOrMemberAssociationId, $registrationValidFrom, $level, $discipline, $registrationNature);

        $playerRegistration->setRegistrationValidTo(new \DateTime('2009-06-15', new \DateTimeZone('UTC')));
        $playerRegistration->setClubTrainingCategory(ClubTrainingCategory::CATEGORY_3);

        return $playerRegistration;
    }
    private function createNationalIdentifier(): NationalIdentifier {
        $identifier = '9876543210';
        $nationalIdentifierNature = NationalIdentifierType::NATIONAL_IDENTIFIER_NATURE_PASSPORT_NUMBER;
        $country = 'CY';

        $nationalIdentifier = new NationalIdentifier($identifier, $nationalIdentifierNature, $country);

        $nationalIdentifier->Description = 'NationalIdentifier test description';
        $nationalIdentifier->setDateFrom(new \DateTime('2003-04-11', new \DateTimeZone('UTC')));
        $nationalIdentifier->setDateTo(new \DateTime('2004-06-01', new \DateTimeZone('UTC')));

        return $nationalIdentifier;
    }
    private function serializePersonLocal(PersonLocal $personLocal): string {
        $xmlSerializer = new PersonLocalXmlSerializer();
        try {
            return $xmlSerializer->serialize($personLocal);
        } catch (XmlSerializationException $e) {
            // Обработка ошибок сериализации, если необходимо
        }
    }
    private function createPersonData(PersonType $person, array $personNames): PersonData {
        return new PersonData($person, $personNames);
    }
    public function registerPerson() {
        $facade = $this->initializeFacade();
        $this->configureEventHandlers($facade);

        $personLocal = $this->createPersonLocal();
        $playerRegistration = $this->createPlayerRegistration($personLocal->PersonFIFAId);
        $nationalIdentifier = $this->createNationalIdentifier();
        $personLocal->addPlayerRegistration($playerRegistration);
        $personLocal->Photo = new Photo(PictureEmbedded::createFromLocalPath(Yii::getAlias("@frontend") . "/web/uploads/post/1/1.jpg"));
        $personLocal->NationalIdentifier = $nationalIdentifier;

        $xmlString = $this->serializePersonLocal($personLocal);

        $personNames = [new PersonName('John', 'Doe')];
        $person = new PersonType();
        $person->setDateOfBirth(new \DateTime('1990-04-26', new \DateTimeZone('UTC')));
        $person->setGender('male');
        $registration = new PlayerRegistrationType();
        $registration->setOrganisationFifaId('105C4WG');
        $registration->setStatus(Status::ACTIVE);
        $registration->setLevel(Level::PRO);
        $registration->setDiscipline(Discipline::FOOTBALL);
        $registration->setRegistrationNature(RegistrationNature::REGISTRATION);
        $person->setPlayerRegistrations([$registration]);

        $personData = $this->createPersonData($person, $personNames);
        $personLocalId = 1;
        $timeoutInSeconds = 20;

        return $facade->registerPersonAndWaitForDetailsInCaseOfDuplicatesByGivingPersonData($personData, $timeoutInSeconds, $personLocalId);
    }
    public function updatePerson(string $personId, array $newPersonNames, \DateTime $dateOfBirth, string $gender) {
        $facade = $this->initializeFacade();

        // Опционально настроить обработчики событий
        // $this->configureEventHandlers($facade);

        // Создать объект PersonType
        $person = new PersonType();
        $person->setDateOfBirth($dateOfBirth);
        $person->setGender($gender);

        // Создать объекты PersonName для новых имен
        $personNames = [];
        foreach ($newPersonNames as $name) {
            $personNames[] = new PersonName($name['firstName'], $name['lastName']);
        }

        // Создать объект PersonData для обновления
        $personData = new PersonData($person, $personNames);

        // Установить таймаут в секундах
        $timeoutInSeconds = 20;

        // Вызвать метод обновления человека и ожидания дополнительных данных в случае обнаружения дубликатов
        return $facade->updatePersonAndWaitForDetailsInCaseOfDuplicates($personId, $timeoutInSeconds, $newPersonNames, $dateOfBirth, $gender);
    }
    private function configureEventHandlers(RegistrationFacade $facade) {
        $facade->configureEventHandlers(new PersonDetailsProvider());
    }
}
