<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $pdf_file
 * @property string|null $image
 * @property int $category_id
 * @property int $author_id
 *
 * @property Category $category
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */

    public $pdfFile;
    public $imageFile;

    private $oldImage;
    private $oldPdfFile;

    public function rules()
    {
        return [
            [['pdf_file', 'image'], 'default', 'value' => null],
            [['title', 'content', 'category_id', 'author_id'], 'required'],
            [['content'], 'string'],
            [['category_id', 'author_id'], 'integer'],
            [['title', 'pdf_file', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['pdfFile'], 'file', 'extensions' => 'pdf'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024 * 1024],
            [['pdfFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 10 * 1024 * 1024],
            [['title'], 'trim'],
            [['title'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'pdf_file' => 'Pdf File',
            'image' => 'Image',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
        ];
    }
    public function afterFind()
    {
        parent::afterFind();
        $this->oldImage = $this->image;
        $this->oldPdfFile = $this->pdf_file;
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public function isLikedBy($userId)
    {
        return Favorite::find()
            ->where(['user_id' => $userId, 'article_id' => $this->id])
            ->exists();
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function saveUploads(): void
    {
        if ($this->imageFile) {
            $this->uploadFile($this->imageFile, 'image', '@webroot/uploads/images/', $this->oldImage);
        }
        if ($this->pdfFile) {
            $this->uploadFile($this->pdfFile, 'pdf_file', '@webroot/uploads/pdfs/', $this->oldPdfFile);
        }
    }

    private function uploadFile($file, string $attribute, string $pathAlias, ?string $oldFilename): void
    {
        $filename = Yii::$app->security->generateRandomString(12) . '.' . $file->extension;
        $file->saveAs(Yii::getAlias($pathAlias) . $filename);

        $this->updateAttributes([$attribute => $filename]);

        if ($oldFilename) {
            @unlink(Yii::getAlias($pathAlias) . $oldFilename);
        }
    }

    public function deleteUploads(): void
    {
        if ($this->image) {
            @unlink(Yii::getAlias('@webroot/uploads/images/') . $this->image);
        }
        if ($this->pdf_file) {
            @unlink(Yii::getAlias('@webroot/uploads/pdfs/') . $this->pdf_file);
        }
    }

}
