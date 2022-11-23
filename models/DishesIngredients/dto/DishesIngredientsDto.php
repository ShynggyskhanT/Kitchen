<?php

declare(strict_types=1);

namespace app\models\DishesIngredients\dto;

final class DishesIngredientsDto
{
    public int $dish_id;

    public int $ingredient_id;

    public function __construct(array $attributes)
    {
        $this->dish_id = $attributes['dish_id'];
        $this->ingredient_id = $attributes['ingredient_id'];
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
