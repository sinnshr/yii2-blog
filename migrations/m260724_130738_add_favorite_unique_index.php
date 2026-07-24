<?php

use yii\db\Migration;

class m260724_130738_add_favorite_unique_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-favorite-user_article', 'favorite', ['user_id', 'article_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-favorite-user_article', 'favorite');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260724_130738_add_favorite_unique_index cannot be reverted.\n";

        return false;
    }
    */
}
