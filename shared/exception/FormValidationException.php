<?php

declare(strict_types=1);

namespace app\shared\exception;

use yii\base\Model;
use yii\web\BadRequestHttpException;

final class FormValidationException extends BadRequestHttpException
{
    public function __construct(
        Model $model,
        string $message = 'Ошибка валидации данных: ',
        int $code = 400
    ) {
        $listErrors = [];

        if ($model->hasErrors()) {
            foreach ($model->getErrors() as $attribute => $errors) {
                $listErrors[] = "[$attribute] " . implode('; ', $errors);
            }
        }

        parent::__construct($message . implode(',', ['errors' => implode('; ', $listErrors)]), $code);
    }
}