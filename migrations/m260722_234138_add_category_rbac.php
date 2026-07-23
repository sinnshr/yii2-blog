<?php

use yii\db\Migration;

class m260722_234138_add_category_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $manageCategory = $auth->createPermission('manageCategory');
        $manageCategory->description = 'Create, update, and delete categories';
        $auth->add($manageCategory);

        $editor = $auth->getRole('editor');
        $auth->addChild($editor, $manageCategory);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->remove($auth->getPermission('manageCategory'));

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260722_234138_add_category_rbac cannot be reverted.\n";

        return false;
    }
    */
}
