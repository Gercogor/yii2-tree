<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller
{

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $demo = $auth->createRole('demo');

        $auth->add($admin);
        $auth->add($demo);

        $auth->addChild($admin, $demo);

        $auth->assign($admin, 100);
        $auth->assign($demo, 101);
    }
}