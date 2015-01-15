<?php

namespace funson86\auth\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use funson86\auth\Module;

/**
 * This is the model class for table "auth_role".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $operation_list
 */
class AuthRole extends \yii\db\ActiveRecord
{
    const SYSTEM_ADMIN = 1;
    const GROUP_ADMIN = 11;
    const COMPANY_ADMIN = 16;

    public $_operations = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('auth', 'ID'),
            'name' => Module::t('auth', 'Name'),
            'description' => Module::t('auth', 'Description'),
            'operation_list' => Module::t('auth', 'Operation List'),
        ];
    }

}
