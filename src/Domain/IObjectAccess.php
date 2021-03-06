<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IStorageModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;

/**
 * Interface IObjectAccess
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IObjectAccess
{
    /**
     * Gets testModule of given Class
     *
     * @param string $class
     * @return IAsqModule
     */
    public function getModule(string $class) : IAsqModule;

    /**
     * Gets all modules of a type
     *
     * @param string $type
     * @return IAsqModule[]
     */
    function getModulesOfType(string $type) : array;

    /**
     * Gets an object from the Test
     *
     * @param string $key
     * @return IAsqObject
     */
    public function getObject(string $key) : IAsqObject;

    /**
     * Gets all objects of modules
     *
     * @param IAsqModule[] $modules
     * @return IAsqObject[]
     */
    function getObjectsOfModules(array $modules) : array;

    /**
     * Gets The Storagemodule of the Plugin
     *
     * @return IStorageModule
     */
    function getStorage() : IStorageModule;

    /**
     * Gets the current ILIASReference
     *
     * @return ILIASReference
     */
    function getReference() : ILIASReference;
}