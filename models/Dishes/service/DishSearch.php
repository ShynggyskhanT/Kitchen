<?php

declare(strict_types=1);

namespace app\models\Dishes\service;

use app\models\Dishes\Dish;
use app\models\Dishes\dto\DishDto;
use app\shared\exception\NotFoundException;

final class DishSearch
{
    public function getById(int $id): DishDto
    {
        $model = Dish::findOne($id);
        if ($model === null) {
            throw new NotFoundException(sprintf("Dish [%s] not found.", $id));
        }

//        var_dump($model->getIngredients());die();

        return $model->toDto();
    }
}