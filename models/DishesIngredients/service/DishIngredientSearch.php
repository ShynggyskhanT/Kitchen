<?php

declare(strict_types=1);

namespace app\models\DishesIngredients\service;

use app\models\Dishes\form\validator\DishIngredientsValidator;
use app\models\DishesIngredients\DishesIngredients;
use app\shared\exception\FormValidationException;
use yii\base\Model;

final class DishIngredientSearch extends Model
{
    public array $ingredients = [];

    public function rules(): array
    {
        return [
            ['ingredients', 'required'],
            ['ingredients', DishIngredientsValidator::class],
        ];
    }

    public function search(array $conditions): void
    {
        $query = DishesIngredients::find();
        $this->setAttributes($conditions);

        if ($this->validate() === false) {
            throw new FormValidationException($this);
        }
        /** @todo: finish. */
    }
}
