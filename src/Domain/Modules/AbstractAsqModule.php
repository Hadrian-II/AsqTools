<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules;

use Fluxlabs\Assessment\Tools\Domain\IObjectAccess;
use Fluxlabs\Assessment\Tools\Domain\Model\Configuration\CompoundConfiguration;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\ModuleDefinition;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Domain\Objects\ObjectConfiguration;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventQueue;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;
use srag\asq\Application\Exception\AsqException;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Abstract class AbstractAsqModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
abstract class AbstractAsqModule implements  IAsqModule
{
    private IEventQueue $event_queue;

    protected IObjectAccess $access;

    private ?AbstractValueObject $configuration = null;

    public final function __construct(IEventQueue $event_queue, IObjectAccess $access)
    {
        $this->event_queue = $event_queue;
        $this->access = $access;

        $this->initialize();
    }

    protected function initialize() : void
    {
        // virtual function
    }

    protected function getModuleConfiguration() : ?AbstractValueObject
    {
        if ($this->configuration === null) {
            $this->configuration = $this->access->getStorage()->getConfiguration(get_class($this));
        }
        return $this->configuration;
    }

    public function processEvent(object $event): void
    {
        // process no events by default
    }

    public function raiseEvent(Event $event) : void
    {
        $this->event_queue->raiseEvent($event);
    }

    private function checkAccess(string $command) : bool
    {
        return true;
    }

    public function executeCommand(string $command): void
    {
        if (!in_array($command, $this->getCommands())) {
            throw new AsqException(
                sprintf(
                    'module: "%s" cannot execute command: "%s"',
                    get_class($this),
                    $command
                )
            );
        }

        if (!$this->checkAccess($command)) {
            throw new AsqException(
                sprintf(
                    'user not allowed to execute command: "%s" on module: "%s"',
                    $command,
                    get_class($this)
                )
            );
        }

        $this->{$command}();
    }

    public function executeTransfer(string $transfer) : void {
        //virtual method
    }

    public function createObject(ObjectConfiguration $config) : IAsqObject
    {
        throw new AsqException(
            sprintf(
                'module of type "%s" cannot create objects',
                get_class($this)
            )
        );
    }

    public function getModuleDefinition(): IModuleDefinition
    {
        return new ModuleDefinition();
    }
}