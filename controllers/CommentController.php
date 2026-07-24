<?php

namespace app\controllers;
use Yii;
use app\models\Comment;
use app\models\CommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
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
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        ['actions' => ['create', 'update', 'delete'], 'allow' => true, 'roles' => ['@']],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'create' => ['POST'],
                        'update' => ['POST'],
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Comment models.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     $searchModel = new CommentSearch();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single Comment model.
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
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Comment();

        if ($model->load($this->request->post())) {
            $model->author_id = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect(['article/view', 'id' => $model->article_id]);
            }
        }

        return $this->redirect(['article/view', 'id' => $model->article_id]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->author_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('شما فقط می‌توانید نظر خود را ویرایش کنید.');
        }

        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'نظر ویرایش شد.');
        } else {
            Yii::$app->session->setFlash('error', 'ویرایش نظر ناموفق بود.');
        }

        return $this->redirect(['article/view', 'id' => $model->article_id]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->author_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('شما فقط می‌توانید نظر خود را حذف کنید.');
        }

        $articleId = $model->article_id;
        $model->delete();

        return $this->redirect(['article/view', 'id' => $articleId]);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
