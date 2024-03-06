<?php

namespace common\components;

use Fifa\ConnectId\Sdk\MessageHandlers\PersonLocalReceivedHandlerInterface;
use Fifa\ConnectId\Sdk\Model\DataStandard\PersonLocal;

class PersonLocalReceivedHandler implements PersonLocalReceivedHandlerInterface {
    public function handle(PersonLocal $personLocal, string $sender)
    {
        // TODO: Implement handle() method.
    }
}