<?php

declare(strict_types=1);

use yii\db\Migration;

final class m221123_025834_create_users_table extends Migration
{
    public string $tableName = '{{%users}}';

    public function safeUp(): bool
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),
                'status' => $this->integer()->notNull() . ' DEFAULT 0',
                'username' => $this->string()->notNull(),
                'access_token' => $this->string()->notNull(),
                'refresh_token' => $this->string()->notNull(),
                'expire' => $this->integer()->notNull()->defaultValue(0),
                'server' => $this->string()->notNull(),
                'errors' => $this->integer()->notNull()->defaultValue(0),
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
