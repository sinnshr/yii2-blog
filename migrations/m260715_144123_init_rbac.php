<?php

use yii\db\Migration;

class m260715_144123_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // permissions
        $createArticle = $auth->createPermission('createArticle');
        $auth->add($createArticle);

        $updateOwnArticle = $auth->createPermission('updateOwnArticle');
        $auth->add($updateOwnArticle);

        $updateAnyArticle = $auth->createPermission('updateAnyArticle');
        $auth->add($updateAnyArticle);

        $deleteArticle = $auth->createPermission('deleteArticle');
        $auth->add($deleteArticle);

        // roles
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createArticle);
        $auth->addChild($author, $updateOwnArticle);

        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $updateAnyArticle);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deleteArticle);
        $auth->addChild($admin, $editor);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260715_144123_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260715_144123_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
