<?php

declare(strict_types=1);

namespace app\models\DishesIngredients\service;

use app\models\DishesIngredients\DishesIngredients;
use app\models\DishesIngredients\dto\DishesIngredientsDto;
use app\shared\exception\ModelSaveException;
use app\shared\exception\NotFoundException;

final class DishIngredientService
{
    /**
     * @param DishesIngredientsDto $dto
     * @return DishesIngredientsDto
     * @throws ModelSaveException
     */
    public function create(DishesIngredientsDto $dto): DishesIngredientsDto
    {
        return $this->save(new DishesIngredients(), $dto->toArray());
    }

    public function deleteByDish(int $dishId): void
    {
        DishesIngredients::deleteAll(['dish_id' => $dishId]);
    }

    public function deleteByIngredient(int $ingredientId): void
    {
        DishesIngredients::deleteAll(['ingredient_id' => $ingredientId]);
    }

    /**
     * @param DishesIngredients $model
     * @param array $attributes
     * @return DishesIngredientsDto
     * @throws ModelSaveException
     */
    private function save(DishesIngredients $model, array $attributes): DishesIngredientsDto
    {
        $model->setAttributes($attributes);

        if ($model->save() === false) {
            throw new ModelSaveException($model);
        }
        $model->refresh();

        return $model->toDto();
    }

    /**
     * @param array $conditions
     * @return DishesIngredients
     * @throws NotFoundException
     */
    private function findOne(array $conditions): DishesIngredients
    {
        $model = DishesIngredients::findOne($conditions);

        if ($model === null) {
            throw new NotFoundException(sprintf("DishesIngredients not found [%s]", implode(', ', $conditions)));
        }

        return $model;
    }
}
