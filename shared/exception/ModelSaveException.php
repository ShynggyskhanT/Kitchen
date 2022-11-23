<?php

declare(strict_types=1);

namespace app\shared\exception;

use RuntimeException;
use yii\base\Model;

final class ModelSaveException extends RuntimeException
{
    public function __construct(
        Model $model,
        string $message = 'Ошибка Сохранения данных: ',
        int $code = 500
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
