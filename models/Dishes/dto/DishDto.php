<?php

declare(strict_types=1);

namespace app\models\Dishes\dto;

/**
 * @psalm-immutable
 */
final class DishDto
{
    public int $id;

    public string $name;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
    }
}
