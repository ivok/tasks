<?php
namespace Application\Service;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;

class SendEmail implements ListenerAggregateInterface
{
    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('completeRegistration', array($this, 'completeRegistration'));
        $this->listeners[] = $events->attach('notification', array($this, 'notification'));
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
        echo "Complete Registration Mail Sent  <br>";
    }

    public function notification(EventInterface $event)
    {
        echo "Notification Mail Sent  <br>";
    }
}