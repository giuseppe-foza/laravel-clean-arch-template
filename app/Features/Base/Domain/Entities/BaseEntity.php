<?php
declare(strict_types=1);

namespace App\Features\Base\Domain\Entities;

use DomainException;

abstract class BaseEntity
{
    protected ?int $entityId;

    public function __construct(?int $entityId = null)
    {
        $this->entityId = $entityId;
    }

    public int $id
    {
        get {
            if (is_null($this->entityId)) {
                throw new DomainException('Entidade sem ID.');
            }

            return $this->entityId;
        }
    }
}
