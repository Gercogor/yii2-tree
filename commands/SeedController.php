<?php

namespace app\commands;

use app\models\Tree;
use Faker\Factory;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    const COUNT_OF_RECORDS = 5000;

    /**
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo 'start seed' . "\n";

        $faker = Factory::create();

        $tree = new Tree();

        $currentTree = Tree::find()->asArray()->all();

        if (count($currentTree) >= self::COUNT_OF_RECORDS) {
            echo 'db ready' . "\n";
            return ExitCode::OK;
        }

        for ($i = 1; $i < self::COUNT_OF_RECORDS; $i++) {
            $tree->setIsNewRecord(true);
            $tree->id = $i;
            $tree->name = $faker->name();
            $digit = $faker->optional()->passthrough(mt_rand(0, $i));
            $tree->parent_id = $digit < $i ? $digit : 0;
            $tree->save();
        }

        echo 'seed complete, db ready' . "\n";

        return ExitCode::OK;
    }
}
