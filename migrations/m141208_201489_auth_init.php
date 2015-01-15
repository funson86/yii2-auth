<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * CLass m141208_201480_blog_init
 * @package funson86\auth\migrations
 *
 * Create auth tables.
 *
 * Will be created 2 tables:
 * - `{{%auth_operation}}` - operation list
 * - `{{%auth_role}}` - auth role
 */
class m141208_201489_auth_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // table auth_operation
        $this->createTable(
            '{{%auth_operation}}',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'name' => Schema::TYPE_STRING . '(32) DEFAULT NULL',
            ],
            $tableOptions
        );

        // table auth_role
        $this->createTable(
            '{{%auth_role}}',
            [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . '(64) NOT NULL',
                'description' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
                'operation_list' => Schema::TYPE_TEXT . '',
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('parent_id', '{{%auth_operation}}', 'parent_id');

        // Add default setting
        $this->execute($this->getOperationSql());
        $this->execute($this->getRoleSql());
        $this->execute($this->getUserSql());
    }

    /**
     * @return string SQL to insert first user
     */
    private function getOperationSql()
    {
        return "INSERT INTO {{%auth_operation}} (`id`, `parent_id`, `name`) VALUES
                ('111', '0', 'basic'),
                ('113', '0', 'user'),
                ('114', '0', 'role'),
                ('11101', '111', 'backendLogin'),
                ('11302', '113', 'viewUser'),
                ('11303', '113', 'createUser'),
                ('11304', '113', 'updateUser'),
                ('11305', '113', 'deleteUser'),
                ('11402', '114', 'viewRole'),
                ('11403', '114', 'createRole'),
                ('11404', '114', 'updateRole'),
                ('11405', '114', 'deleteRole')
                ";
    }

    /**
     * @return string SQL to insert first user
     */
    private function getRoleSql()
    {
        return "INSERT INTO {{%auth_role}} (`id`, `name`, `description`, `operation_list`) VALUES
                ('1', 'Super Admin', '', 'all'),
                ('3', 'Normal Admin', '', 'backendLogin;viewUser;viewRole')
                ";
    }

    /**
     * @return string SQL to insert first user
     */
    private function getUserSql()
    {
        return "ALTER TABLE {{%user}} ADD COLUMN `auth_role` int(11) AFTER `email`;
                UPDATE {{%user}} set `auth_role` = 3;
                UPDATE {{%user}} set `auth_role` = 1 where `username` = 'admin';
                ";
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("ALTER TABLE {{%user}} DROP COLUMN `auth_role`");
        $this->dropTable('{{%auth_role}}');
        $this->dropTable('{{%auth_operation}}');
    }
}
