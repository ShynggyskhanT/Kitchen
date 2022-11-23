<?php

declare(strict_types=1);

namespace app\models\Ingredients;

use yii\db\ActiveQuery;

final class IngredientQuery extends ActiveQuery
{
    public function enabled(): self
    {
        $this->andWhere(['enabled' => true]);

        return $this;
    }
}
