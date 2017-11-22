<?php

namespace app\controllers;

use Yii;

use app\models\PreForum;
use app\models\PreForumPost;
use app\models\PreForumThread;
use app\models\PreForumThreadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
Yii::setAlias('forum_icon', '@web/uploads/forum/icon/');
Yii::setAlias('avatar', '@web/uploads/user/avatar/default/');
Yii::setAlias('photo', '@web/uploads/home/photo/');
/**
 * PreForumThreadController implements the CRUD actions for PreForumThread model.
 */
class PreForumThreadController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PreForumThread models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreForumThreadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreForumThread model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='equipo';
        $model = $this->findModel($id);
        $newPost = new PreForumPost();
        
        if ($newPost->load(Yii::$app->request->post())) {
            $newPost->thread_id = $model->id;
            if ($newPost->save()){
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 

        return $this->render('view', [
            'model' => $model,
            'newPost' => $newPost,
        ]);
    }

    /**
     * Creates a new PreForumThread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreForumThread();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PreForumThread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PreForumThread model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $forum=PreForum::find()->where('id=:id',[':id'=>$model->board['forum_id']])->one();
        if ($model->user_id === Yii::$app->user->id || $model->board['user_id'] == Yii::$app->user->id) {
            $board_id = $model->board_id;
            PreForumPost::deleteAll(['thread_id' => $model->id]);
            //return $model->delete();
            $model->delete();
            return $this->redirect(['pre-forum/view','id'=>$forum->forum_url]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * Finds the PreForumThread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreForumThread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreForumThread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
