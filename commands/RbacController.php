<?php

declare(strict_types=1);

namespace app\commands;

use app\rbac\UserGroupRule;
use Yii;
use Exception;
use yii\console\Controller;

final class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;

        $rule = new UserGroupRule();
        $auth->add($rule);

        // добавляем роль "author"
        $user = $auth->createRole('user');
        $user->ruleName = $rule->name;
        $auth->add($user);

        // добавляем роль "admin"
        // а также все разрешения роли "user"
        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
}