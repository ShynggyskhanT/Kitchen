<?php

declare(strict_types=1);

namespace app\models\Dishes;

use app\models\Dishes\dto\DishDto;
use app\models\DishesIngredients\DishesIngredients;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 */
final class Dish extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%dishes}}';
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => static function () {
                    return gmdate('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function getIngredients(): ActiveQuery
    {
        return $this->hasMany(DishesIngredients::class, ['dish_id' => 'id']);
    }

    public function toDto(): DishDto
    {
        return new DishDto($this->toArray());
    }
}