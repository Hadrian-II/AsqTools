<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use ActiveRecord;
use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IStorageModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use ILIAS\Data\UUID\Uuid;

/**
 * class ObjectAccess
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ILIASReference
{
    private string $ilias_type;

    private int $ilias_id;

    private Uuid $id;

    private ActiveRecord $settings;

    public function __construct(Uuid $id, string $ilias_type, int $ilias_id, ActiveRecord $settings)
    {
        $this->id = $id;
        $this->ilias_id = $ilias_id;
        $this->ilias_type = $ilias_type;
        $this->settings = $settings;
    }

    public function getId() : Uuid
    {
        return $this->id;
    }

    public function getIliasId() :int
    {
        return $this->ilias_id;
    }

    public function getIliasType() : string
    {
        return $this->ilias_type;
    }

    public function getSettings() : ActiveRecord
    {
        return $this->settings;
    }
}