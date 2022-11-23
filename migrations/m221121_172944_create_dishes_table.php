<?php

declare(strict_types=1);

use yii\db\Migration;

final class m221121_172944_create_dishes_table extends Migration
{
    public string $tableName = '{{%dishes}}';

    public function safeUp(): bool
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->comment('Name of Dish'),
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
