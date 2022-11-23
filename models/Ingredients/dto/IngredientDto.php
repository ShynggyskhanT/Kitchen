<?php

declare(strict_types=1);

namespace app\models\Ingredients\dto;

/**
 * @psalm-immutable
 */
final class IngredientDto
{
    public int $id;

    public string $name;

    public bool $enabled;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->enabled = (bool)$attributes['enabled'];
    }
}
