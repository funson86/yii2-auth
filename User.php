<?php
/**
 * User
 *
 */

namespace funson86\auth;

use funson86\auth\models\AuthRole;
use Yii;

class User extends \yii\web\User
{
    private $_operations;
    /**
     * Checks if the user can perform the operation as specified by the given permission.
     *
     * if super admin, the operation role is 'all', return true all the time.
     *
     *
     * @param string $permissionName the name of the permission (e.g. "edit post") that needs access check.
     * @param array $params name-value pairs that would be passed to the rules associated
     * with the roles and permissions assigned to the user. A param with name 'user' is added to
     * this array, which holds the value of [[id]].
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, its result will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call
     * [[\yii\rbac\ManagerInterface::checkAccess()]] to obtain the up-to-date access result. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return boolean whether the user can perform the operation as specified by the given permission.
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && isset($this->_operations)) {
           $operations =  $this->_operations;
        } else {
            $operations = AuthRole::findOne(Yii::$app->user->identity->auth_role)->operation_list;
            $this->_operations = $operations;
        }

        //super admin
        if ($operations == 'all')
            return true;

        if (strpos(';' . $operations . ';', $permissionName) === false)
            return false;
        else
            return true;
    }
}
