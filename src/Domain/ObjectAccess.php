<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IStorageModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;

/**
 * class ObjectAccess
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ObjectAccess implements IObjectAccess
{
    private IAsqPlugin $plugin;

    public function __construct(IAsqPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getModule(string $class) : IAsqModule
    {
        return $this->plugin->getModule($class);
    }

    function getModulesOfType(string $type): array
    {
        return $this->plugin->getModulesOfType($type);
    }

    public function getObject(string $key) : IAsqObject
    {
        return $this->plugin->getObject($key);
    }

    public function getObjectsOfModules(array $modules) : array
    {
        return $this->plugin->getObjectsOfModules($modules);
    }

    public function getStorage() : IStorageModule
    {
        return $this->plugin->getStorage(IStorageModule::class);
    }

    public function getReference(): ILIASReference
    {
        return $this->plugin->getReference();
    }
}