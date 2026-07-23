<?php

use yii\db\Migration;

class m260723_021620_restrict_article_category_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-article-category', 'article');
        $this->addForeignKey('fk-article-category', 'article', 'category_id', 'category', 'id', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-article-category', 'article');
        $this->addForeignKey('fk-article-category', 'article', 'category_id', 'category', 'id', 'CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260723_021620_restrict_article_category_fk cannot be reverted.\n";

        return false;
    }
    */
}
