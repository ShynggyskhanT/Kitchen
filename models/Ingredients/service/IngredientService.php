<?php

declare(strict_types=1);

namespace app\models\Ingredients\service;

use app\models\Ingredients\dto\IngredientDto;
use app\models\Ingredients\dto\IngredientFormDto;
use app\models\Ingredients\Ingredient;
use app\shared\exception\ModelSaveException;
use app\shared\exception\NotFoundException;

final class IngredientService
{
    /**
     * @param IngredientFormDto $formDto
     * @return IngredientDto
     * @throws ModelSaveException
     */
    public function create(IngredientFormDto $formDto): IngredientDto
    {
        return $this->save(new Ingredient(), $formDto->toArray());
    }

    /**
     * @param int $id
     * @param IngredientFormDto $formDto
     * @return IngredientDto
     * @throws ModelSaveException
     * @throws NotFoundException
     */
    public function update(int $id, IngredientFormDto $formDto): IngredientDto
    {
        return $this->save($this->findOne(['id' => $id]), $formDto->toArray());
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws ModelSaveException
     * @throws NotFoundException
     */
    public function enable(int $id): IngredientDto
    {
        return $this->save($this->findOne(['id' => $id]), ['enabled' => true]);
    }

    public function delete(int $id): void
    {
        Ingredient::deleteAll(['id' => $id]);
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws ModelSaveException
     * @throws NotFoundException
     */
    public function disable(int $id): IngredientDto
    {
        return $this->save($this->findOne(['id' => $id]), ['enabled' => false]);
    }

    /**
     * @param Ingredient $model
     * @param array $attributes
     * @return IngredientDto
     * @throws ModelSaveException
     */
    private function save(Ingredient $model, array $attributes): IngredientDto
    {
        $model->setAttributes($attributes);
        if ($model->getIsNewRecord()) {
            $model->enabled = true;
        }

        if ($model->save() === false) {
            throw new ModelSaveException($model);
        }
        $model->refresh();

        return $model->toDto();
    }

    /**
     * @param array $conditions
     * @return Ingredient
     * @throws NotFoundException
     */
    private function findOne(array $conditions): Ingredient
    {
        $model = Ingredient::findOne($conditions);

        if ($model === null) {
            throw new NotFoundException(sprintf("Ingredient not found [%s]", implode(', ', $conditions)));
        }

        return $model;
    }
}
