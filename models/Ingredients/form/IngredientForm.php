<?php

declare(strict_types=1);

namespace app\models\Ingredients\form;

use yii\base\Model;
use app\models\Ingredients\dto\IngredientFormDto;

final class IngredientForm extends Model
{
    public ?string $name = null;

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function toDto(): IngredientFormDto
    {
        return new IngredientFormDto($this->name);
    }
}
