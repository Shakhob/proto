<?php

namespace common\components;

use Fifa\ConnectId\Sdk\Registration\Event\Handler\EventHandlerInterface;

class TestEventHandler implements EventHandlerInterface
{

    public function execute($eventData)
    {
        echo 'Message content: ' . $eventData->getContent();
    }
}