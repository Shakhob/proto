<?php

namespace frontend\models;

use Fifa\ConnectId\Sdk\Model\PersonDetailsRequest;
use Fifa\ConnectId\Sdk\Registration\PersonDetailsProviderInterface;

class PersonDetailsProvider implements PersonDetailsProviderInterface
{
    /**
     * @param PersonDetailsRequest $request
     * @return null|string
     */
    public function getPersonDetails(PersonDetailsRequest $request): ?string
    {
        // TODO: Получение данных из вашей локальной базы данных и преобразование в стандарт данных FIFA
        // Замените этот код на вашу реальную логику
        $xmlString = 'asdasd'; // Ваша текущая строка данных, замените ее на реальные данные
        return $xmlString;
    }
}