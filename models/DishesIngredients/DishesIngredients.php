<?php

declare(strict_types=1);

namespace app\models\DishesIngredients;

use app\models\Dishes\Dish;
use app\models\DishesIngredients\dto\DishesIngredientsDto;
use app\models\Ingredients\Ingredient;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $dish_id
 * @property int $ingredient_id
 */
final class DishesIngredients extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%dishes_ingredients}}';
    }

    public function rules(): array
    {
        return [
            [['dish_id', 'ingredient_id'], 'required'],
            [['dish_id', 'ingredient_id'], 'integer'],
            [
                'dish_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Dish::class,
                'targetAttribute' => ['dish_id' => 'id'],
            ],
            [
                'ingredient_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Ingredient::class,
                'targetAttribute' => ['ingredient_id' => 'id'],
            ],
        ];
    }

    public function getDish(): ActiveQuery
    {
        return $this->hasOne(Dish::class, ['id' =>'dish_id']);
    }

    public function getIngredient(): ActiveQuery
    {
        return $this->hasOne(Ingredient::class, ['id' =>'ingredient_id']);
    }

    public function toDto(): DishesIngredientsDto
    {
        return new DishesIngredientsDto($this->toArray());
    }
}