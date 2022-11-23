<?php

declare(strict_types=1);

namespace app\models\Dishes\service;

use app\models\Dishes\Dish;
use app\models\Dishes\dto\DishDto;
use app\models\Dishes\dto\DishFormDto;
use app\shared\exception\ModelSaveException;
use app\shared\exception\NotFoundException;

final class DishService
{
    /**
     * @param DishFormDto $formDto
     * @return DishDto
     * @throws ModelSaveException
     */
    public function create(DishFormDto $formDto): DishDto
    {
        return $this->save(new Dish(), $formDto->toArray());
    }

    /**
     * @param int $id
     * @param DishFormDto $formDto
     * @return DishDto
     * @throws ModelSaveException
     * @throws NotFoundException
     */
    public function update(int $id, DishFormDto $formDto): DishDto
    {
        return $this->save($this->findOne(['id' => $id]), $formDto->toArray());
    }

    public function delete(int $id): void
    {
        Dish::deleteAll(['id' => $id]);
    }

    /**
     * @param Dish $model
     * @param array $attributes
     * @return DishDto
     * @throws ModelSaveException
     */
    private function save(Dish $model, array $attributes): DishDto
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
     * @return Dish
     * @throws NotFoundException
     */
    private function findOne(array $conditions): Dish
    {
        $model = Dish::findOne($conditions);

        if ($model === null) {
            throw new NotFoundException(sprintf("Dish not found [%s]", implode(', ', $conditions)));
        }

        return $model;
    }
}
