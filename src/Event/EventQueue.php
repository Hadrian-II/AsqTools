<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event;

/**
 * Class EventQueue
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class EventQueue implements IEventQueue
{
    /**
     * @var IEventUser[] $users
     */
    private array $users;

    /**
     * @var Event[] $events
     */
    private array $events;

    private bool $lock = false;

    public function __construct() {
        $this->users = [];
        $this->events = [];
    }

    public function addUser(IEventUser $user): void
    {
        $this->users[] = $user;
    }

    public function raiseEvent(Event $event): void
    {
        $this->events[] = $event;

        if ($this->lock === false)
        {
            $this->lock = true;
            $this->processNextEvent();;
        }
    }

    private function processNextEvent() : void
    {
        while ($event = array_shift($this->events)) {
            foreach ($this->users as $user) {
                $user->processEvent($event);
            }
        }

        $this->lock = false;
    }
}