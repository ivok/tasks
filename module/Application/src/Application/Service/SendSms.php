<?php
namespace Application\Service;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;

class SendSms implements ListenerAggregateInterface
{
    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('completeRegistration', array($this, 'completeRegistration'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function completeRegistration(EventInterface $event)
    {
        echo "Registration Complete Sms Sent <br>";
    }
}