<?php

declare(strict_types=1);

use yii\db\Migration;

final class m221121_173113_create_dishes_ingredients_table extends Migration
{
    public string $tableName = '{{%dishes_ingredients}}';

    public function safeUp(): bool
    {
        $this->createTable(
            $this->tableName,
            [
                'dish_id' => $this->integer()->notNull(),
                'ingredient_id' => $this->integer()->notNull(),
            ]
        );

        $this->addForeignKey(
            'FK_dishes_dishes_ingredients',
            $this->tableName,
            'dish_id',
            'dishes',
            'id'
        );

        $this->addForeignKey(
            'FK_ingredients_dishes_ingredients',
            $this->tableName,
            'ingredient_id',
            'ingredients',
            'id'
        );

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable($this->tableName);

        return true;
    }
}
