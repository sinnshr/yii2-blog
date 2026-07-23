<?php

namespace app\controllers;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(

            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['createArticle'],
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['updateOwnArticle', 'updateAnyArticle'],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['deleteArticle'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Article models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($this->request->isPost) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->pdfFile = UploadedFile::getInstance($model, 'pdfFile');

            if ($model->imageFile) {
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs(Yii::getAlias('@webroot/uploads/images/') . $model->image);
            }
            if ($model->pdfFile) {
                $model->pdf_file = $model->pdfFile->baseName . "." . $model->pdfFile->extension;
                $model->pdfFile->saveAs(Yii::getAlias('@webroot/uploads/pdfs/') . $model->pdf_file);
            }
            if ($model->load($this->request->post())) {
                $model->author_id = Yii::$app->user->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        $model->pdfFile = UploadedFile::getInstance($model, 'pdfFile');

        if ($model->imageFile) {
            $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
            $model->imageFile->saveAs(Yii::getAlias('@webroot/uploads/images/') . $model->image);
        }
        if ($model->pdfFile) {
            $model->pdf_file = $model->pdfFile->baseName . "." . $model->pdfFile->extension;
            $model->pdfFile->saveAs(Yii::getAlias('@webroot/uploads/pdfs/') . $model->pdf_file);
        }

        if (!Yii::$app->user->can('updateAnyArticle') && $model->author_id !== Yii::$app->user->id) { // editing permission
            throw new ForbiddenHttpException('فقط می‌توانید مقاله‌های خود را ویرایش کنید.');
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
