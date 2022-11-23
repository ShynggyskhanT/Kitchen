<?php

declare(strict_types=1);

namespace app\models\Dishes\dto;

/**
 * @psalm-immutable
 */
final class DishFormDto
{
    public ?string $name = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
