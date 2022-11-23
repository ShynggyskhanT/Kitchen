<?php

declare(strict_types=1);

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params): bool
    {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->id;
            if ($item->name === 'admin') {
                return $group === 1;
            }

            if ($item->name === 'user') {
                return $group === 1 || $group === 2;
            }
        }
        return false;
    }
}

