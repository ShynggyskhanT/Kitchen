<?php

declare(strict_types=1);

namespace app\models\Dishes\form\validator;

use yii\validators\EachValidator;
use yii\validators\Validator;

final class DishIngredientsValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        /** @var int[] $ingredients */
        $ingredients = $model->$attribute;

        if (count($ingredients) < 2) {
            $model->addError($attribute, sprintf("Not enough ingredients."));
            return;
        }
        if (count($ingredients) > 5) {
            $model->addError($attribute, sprintf("Too enough ingredients."));
            return;
        }

        if (array_diff_assoc($ingredients, array_unique($ingredients)) !== []) {
            $model->addError($attribute, sprintf("Duplicate of ingredients."));
            return;
        }

        $this->validateIntegers($model, $attribute);
    }

    private function validateIntegers($model, $attribute): void
    {
        $each = self::createValidator(
            EachValidator::class,
            $model,
            $attribute,
            [
                'rule' => ['integer'],
            ],
        );
        $each->validateAttributes($model, $attribute);

    }
}
