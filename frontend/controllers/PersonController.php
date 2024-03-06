<?php

namespace frontend\controllers;

use common\models\RegistrationModel;
use yii\web\Controller;

class PersonController extends Controller
{
    public function actionIndex() {
        // Обработка данных из формы
        $model = new RegistrationModel();
        $result = $model->registerPerson();
//        echo "<pre>"; print_r($result); echo "</pre>";
//DIE;

        if ($result->isSuccessful()) {
            echo 'Person successfully registered with unique FIFA ID: ' . $result->getUniqueFifaId() . '.';
        }
        else {
            echo 'Duplicates found.';

//            foreach ($result->getPersonDuplicateWithDetails() as $duplicateWithDetails) {
//                $duplicate = $duplicateWithDetails->getDuplicate();
//                $idOfDuplicatedPerson = $duplicate->getPersonFifaId();
//                $proximityScore = $duplicate->getProximityScore();
//                $duplicatedPersonRegistrationDate = $duplicate->getPersonRegistrationContext()->getRegistrationDate();
//
//                // In order to determine which record is primary, it is recommended to consider the original registration date.
//                // The following article provides more information: [article](https://support.id.ma.services/support/solutions/articles/7000080785-merging-how-to-decide-which-record-is-primary).
//
//                $dataReceived = $duplicateWithDetails->getPersonDetails() == null
//                    ? "<detailed person data not received from other MA - timeout>"
//                    : $duplicateWithDetails->getPersonDetails()->getXmlData();
//
//                echo sprintf('FIFA ID: %s, score: %s, registration date: %s,  FIFA Data XML: %s',
//                    $idOfDuplicatedPerson,
//                    $proximityScore,
//                    $duplicatedPersonRegistrationDate->format('Y-m-d'),
//                    $dataReceived
//                );
//            }
        }
        echo "<pre>"; print_r($duplicate); echo "</pre>";DIE;
    }
}