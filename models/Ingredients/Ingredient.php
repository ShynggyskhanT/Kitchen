<?php

declare(strict_types=1);

namespace app\models\Ingredients;

use app\models\Ingredients\dto\IngredientDto;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property bool $enabled
 * @property int $created_at
 * @property int $updated_at
 */
final class Ingredient extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%ingredients}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'enabled'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['enabled'], 'boolean'],
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

    /**
     * @return IngredientQuery
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function find(): IngredientQuery
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Yii::createObject(IngredientQuery::class, [__CLASS__]);
    }

    public function toDto(): IngredientDto
    {
        return new IngredientDto($this->toArray());
    }
}