<?php

namespace funson86\auth\models;

use Yii;
use funson86\auth\Module;

/**
 * This is the model class for table "auth_operation".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 */
class AuthOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('auth', 'ID'),
            'parent_id' => Module::t('auth', 'Parent ID'),
            'name' => Module::t('auth', 'Name'),
        ];
    }
}
