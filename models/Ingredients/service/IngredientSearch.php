<?php

declare(strict_types=1);

namespace app\models\Ingredients\service;

use app\models\Ingredients\dto\IngredientDto;
use app\models\Ingredients\Ingredient;
use app\shared\exception\NotFoundException;
use yii\data\ActiveDataProvider;

final class IngredientSearch
{
    public function getById(int $id): IngredientDto
    {
        $model = Ingredient::findOne($id);
        if ($model === null) {
            throw new NotFoundException(sprintf("Ingredient [%s] not found.", $id));
        }

        return $model->toDto();
    }

    public function getAll(): ActiveDataProvider
    {
        $query = Ingredient::find()
            ->enabled();

        return new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]
        );
    }
}
