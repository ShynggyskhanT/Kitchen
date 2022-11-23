<?php

declare(strict_types=1);

use yii\db\Migration;

final class m221121_090422_create_ingredients_table extends Migration
{
    public string $tableName = '{{%ingredients}}';

    public function safeUp(): bool
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->comment('Name of Ingredient'),
                'enabled' => $this->boolean()->defaultValue(true),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            ]
        );

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable($this->tableName);

        return true;
    }
}
