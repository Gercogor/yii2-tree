<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 */
class Menu extends \yii\db\ActiveRecord
{
    public $sub;

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::class
            ],
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['lft', 'rgt', 'depth'], 'default', 'value' => null],
            [['lft', 'rgt', 'depth', 'sub'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lft', 'rgt', 'depth'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}
