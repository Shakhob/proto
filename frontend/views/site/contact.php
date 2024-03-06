<?php

global $executionTime, $statusCode, $personDetailsProvider;

use common\components\PersonLocalReceivedHandler;
use common\components\TestEventHandler;
use Fifa\ConnectId\Sdk\Api\Model\NationalIdentifierType;
use Fifa\ConnectId\Sdk\Api\Model\PersonType;
use Fifa\ConnectId\Sdk\Api\Model\PlayerRegistrationType;
use Fifa\ConnectId\Sdk\Environment\Environment;
use Fifa\ConnectId\Sdk\Exception\InvalidClientDataException;
use Fifa\ConnectId\Sdk\Exception\XmlDeserializationException;
use Fifa\ConnectId\Sdk\Exception\XmlSerializationException;
use Fifa\ConnectId\Sdk\MessageHandlers\PersonLocalMessageHandler;
use Fifa\ConnectId\Sdk\Model\DataStandard\NationalIdentifier;
use Fifa\ConnectId\Sdk\Model\DataStandard\PersonLocal;
use Fifa\ConnectId\Sdk\Model\DataStandard\Photo;
use Fifa\ConnectId\Sdk\Model\DataStandard\PictureEmbedded;
use Fifa\ConnectId\Sdk\Model\DataStandard\PlayerRegistration;
use Fifa\ConnectId\Sdk\Model\PersonData;
use Fifa\ConnectId\Sdk\Model\PersonName;
use Fifa\ConnectId\Sdk\PersonLocalSender;
use Fifa\ConnectId\Sdk\Registration\Model\RegistrationFacadeSettings;
use Fifa\ConnectId\Sdk\Registration\RegistrationFacade;
use Fifa\ConnectId\Sdk\Registration\ValidationException;
use Fifa\ConnectId\Sdk\Storage\SqliteStorage;
use Fifa\ConnectId\Sdk\Util\Data\ClubTrainingCategory;
use Fifa\ConnectId\Sdk\Util\Data\Discipline;
use Fifa\ConnectId\Sdk\Util\Data\Gender;
use Fifa\ConnectId\Sdk\Util\Data\Person\Level;
use Fifa\ConnectId\Sdk\Util\Data\RegistrationNature;
use Fifa\ConnectId\Sdk\Util\Data\Status;
use Fifa\ConnectId\Sdk\Util\File;
use Fifa\ConnectId\Sdk\Util\PersonLocalXmlSerializer\PersonLocalXmlSerializer;
use Fifa\ConnectId\Sdk\Util\XsdSchemaValidator\XsdSchemaValidator;
use Fifa\ConnectServiceBus\Sdk\Authentication\Model\ClientCredentials;
use Fifa\ConnectServiceBus\Sdk\Encryption\Decrypt\PrivateCertificateMemoryStorage;
use Fifa\ConnectServiceBus\Sdk\Encryption\Model\PrivateCertificate;
use Fifa\ConnectServiceBus\Sdk\Exception\AuthenticationException;
use Fifa\ConnectServiceBus\Sdk\Exception\FifaConnectServiceBusSdkException;
use Fifa\ConnectServiceBus\Sdk\Exception\QueueNotFoundException;
use Fifa\ConnectServiceBus\Sdk\Exception\UnauthorizedException;
use Fifa\ConnectServiceBus\Sdk\Utils\ToStringConverter;
use frontend\models\MyLogger;
use frontend\models\PersonDetailsProvider;
use Psr\Log\AbstractLogger;
$filePath = Yii::getAlias("@frontend") . '/openssl_output/private_key.pem';

$clientCredentials = new ClientCredentials('78123107-83d3-49e7-8692-05619e06916c', 'iKp8Q~Qg6dRTgx6smhwFyZuKfkOwUCab4NSv5caS');

$logger = new MyLogger(); // Замените MyLogger на свой класс логгера
$organisationType = 'asdasd';
$httpHeaders = 'asdasd';
$logger->debug('Organisations unmerged with following response', array(
    'organisationType' => $organisationType,
    'statusCode' => strval($statusCode),
    'httpHeader' => 'asdasd'
));
$privateCertificate = new PrivateCertificate(File::getContents($filePath), 'ufaid');
$privateStorage = new PrivateCertificateMemoryStorage($privateCertificate);
$useEncryption = false;

$executionTime = 60;
$storage = SqliteStorage::getInstance($logger);

$privateCertificate = new PrivateCertificate(File::getContents($filePath), 'SomePassword');
$privateStorage = new PrivateCertificateMemoryStorage($privateCertificate);
$facadeSettings = new RegistrationFacadeSettings($storage, $executionTime, $useEncryption);
$facade = new RegistrationFacade(Environment::Beta(), $clientCredentials, $privateStorage, $logger, $facadeSettings);
$facade->configureEventHandlers(new PersonDetailsProvider());
//$facade->receiveMessages();
$localLastName = 'ΧΑΡΑΛΑΜΠΟΥΣ';
$gender = Gender::MALE;
$nationality = 'CY';
$dateOfBirth = new \DateTime('1989-05-31', new \DateTimeZone('UTC'));
$countryOfBirth = 'CY';
$placeOfBirth = 'Larnaca';
$localLanguage = 'gre';
$localCountry = 'CY';
$personFIFAId = '105C3Z1';

// creating an instance of the object
try {
    $personLocal = new PersonLocal(
        $localLastName, $gender, $nationality, $dateOfBirth, $countryOfBirth, $placeOfBirth, $localLanguage, $localCountry, $personFIFAId
    );
} catch (\Fifa\ConnectId\Sdk\Util\ToString\Exception\ToStringException $e) {
}

// optional fields
$personLocal->LocalFirstName = 'ΑΓΓΕΛΗΣ';
$personLocal->LocalSystemMAId = '1234567';
$personLocal->InternationalFirstName = 'ANGELIS';
$personLocal->InternationalLastName = 'CHARALAMBOUS';
$personLocal->RegionOfBirth = 'Larnaca';
$personLocal->PopularName = 'Angelis Angeli';
$personLocal->SecondNationality = 'GR';
$personFIFAId = '105C4WG';
$status = Status::ACTIVE;
$clubOrMemberAssociationId = '105C40I';
$registrationValidFrom = new \DateTime('2003-04-11', new \DateTimeZone('UTC'));
$level = strtolower(Level::AMATEUR);
$discipline = Discipline::FOOTBALL;
$registrationNature = RegistrationNature::REGISTRATION;

// creating an instance of the object
$playerRegistration = new PlayerRegistration(
    $personFIFAId, $status, $clubOrMemberAssociationId, $registrationValidFrom, $level, $discipline, $registrationNature
);

// optional fields
$playerRegistration->setRegistrationValidTo(new \DateTime('2009-06-15', new \DateTimeZone('UTC')));
$playerRegistration->setClubTrainingCategory(ClubTrainingCategory::CATEGORY_3);



// include photo in PersonLocal
$identifier = '9876543210';
$nationalIdentifierNature = NationalIdentifierType::NATIONAL_IDENTIFIER_NATURE_PASSPORT_NUMBER;
$country = 'CY';

// creating an instance of the object
$nationalIdentifier = new NationalIdentifier($identifier, $nationalIdentifierNature, $country);

// optional fields
$nationalIdentifier->Description = 'NationalIdentifier test description';
$nationalIdentifier->setDateFrom(new \DateTime('2003-04-11', new \DateTimeZone('UTC')));
$nationalIdentifier->setDateTo(new \DateTime('2004-06-01', new \DateTimeZone('UTC')));

// include Photo in PersonLocal
$personLocal->NationalIdentifier = $nationalIdentifier;
$xmlSerializer = new PersonLocalXmlSerializer();
$xmlString = null;
// PersonDetailsRequest is available in getPersonDetails() method of PersonDetailsProviderInterface interface

try {
    $xmlString = $xmlSerializer->serialize($personLocal);
}
catch (XmlSerializationException $e) {
    // handle serialization exception
    $logger->error(sprintf('Unable to serialize XML for person: %s. Details: %s', $personFIFAId, $e->__toString()));
}

$xmlSerializer = new PersonLocalXmlSerializer();

$personNames = array();
$personNames[] = new PersonName('Cristiano', 'Ronaldo');

// setup birth date
$person = new PersonType();
$person->setDateOfBirth(new \DateTime('1985-02-05', new \DateTimeZone('UTC')));
$person->setGender('male');

// setup registrations
$registration = new PlayerRegistrationType();
$registration->setOrganisationFifaId('105C4WG');
$registration->setStatus(Status::ACTIVE);
$registration->setLevel(Level::PRO);
$registration->setDiscipline(Discipline::FOOTBALL);
$registration->setRegistrationNature(RegistrationNature::REGISTRATION);

$person->setPlayerRegistrations(array($registration));

// finally create PersonData
$personData = new PersonData($person, $personNames);
$personLocalId = 1;
$timeoutInSeconds = 20;


$result = $facade->registerPersonAndWaitForDetailsInCaseOfDuplicatesByGivingPersonData($personData, $timeoutInSeconds, $personLocalId);


if ($result->isSuccessful()) {
    echo 'Person successfully registered with unique FIFA ID: ' . $result->getUniqueFifaId() . '.';
}
else {
    echo 'Duplicates found.';

    foreach ($result->getPersonDuplicateWithDetails() as $duplicateWithDetails) {
        $duplicate = $duplicateWithDetails->getDuplicate();
        $idOfDuplicatedPerson = $duplicate->getPersonFifaId();
        $proximityScore = $duplicate->getProximityScore();
        $duplicatedPersonRegistrationDate = $duplicate->getPersonRegistrationContext()->getRegistrationDate();

        // In order to determine which record is primary, it is recommended to consider the original registration date.
        // The following article provides more information: [article](https://support.id.ma.services/support/solutions/articles/7000080785-merging-how-to-decide-which-record-is-primary).

        $dataReceived = $duplicateWithDetails->getPersonDetails() == null
            ? "<detailed person data not received from other MA - timeout>"
            : $duplicateWithDetails->getPersonDetails()->getXmlData();
//
//        echo sprintf('FIFA ID: %s, score: %s, registration date: %s,  FIFA Data XML: %s',
//            $idOfDuplicatedPerson,
//            $proximityScore,
//            $duplicatedPersonRegistrationDate->format('Y-m-d'),
//            $dataReceived
//        );
    }
}
$data = new \Fifa\ConnectId\Sdk\Model\PersonDetails("$personFIFAId",$xmlString,'10DIFN2');
//$ppp = $storage->put($data);
$personLocalSender = new PersonLocalSender($facade->getServiceBusClient());

$recipient = '105C3ZB_CSRS';
$messageType = 'expected-message-type';
$personLocal = new PersonLocal(
    'ΧΑΡΑΛΑΜΠΟΥΣ', Gender::MALE, 'CY', new \DateTime('1989-05-31', new \DateTimeZone('UTC')),
    'CY', 'Larnaca', 'gre', 'CY', '10FSRY8'
);

try {
    $personLocalSender->send($personLocal, $recipient, $messageType);
} catch (XmlSerializationException $e) {
    // handle serialization exception
} catch (ValidationException $e) {
    // validation error occurred
} catch (AuthenticationException $e) {
    // invalid client credentials
} catch (InvalidClientDataException $e) {
    $details = $e->getBadRequestResponse();
} catch (QueueNotFoundException $e) {
    // invalid recipient
} catch (UnauthorizedException $e) {
    // unauthorized
} catch (FifaConnectServiceBusSdkException $e) {
    $details = $e->getResponseBody();
}

$personLocalReceivedHandler = new PersonLocalReceivedHandler();
$messageType = 'expected-message-type';
$personLocalMessageHandler = new PersonLocalMessageHandler($personLocalReceivedHandler, $messageType);

// add the new message handler to the collection of existing ones
$myMessageHandlers[] = $personLocalMessageHandler;
$personDetailsProvider = new PersonDetailsProvider;
$facade->configureEventHandlers($personDetailsProvider, $myMessageHandlers);
echo "<pre>"; print_r($result); echo "</pre>";
