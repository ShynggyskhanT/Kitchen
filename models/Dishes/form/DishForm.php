<?php

declare(strict_types=1);

namespace app\models\Dishes\form;

use app\models\Dishes\dto\DishFormDto;
use app\models\Dishes\form\validator\DishIngredientsValidator;
use yii\base\Model;

final class DishForm extends Model
{
    public ?string $name = null;

    /**
     * Ingredients Ids
     * @var int[]
     */
    public array $ingredients = [];

    public function rules(): array
    {
        return [
            [['name', 'ingredients'], 'required'],
            ['name', 'string', 'max' => 255],
            ['ingredients', DishIngredientsValidator::class],
        ];
    }

    public function toDto(): DishFormDto
    {
        return new DishFormDto($this->name);
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}
