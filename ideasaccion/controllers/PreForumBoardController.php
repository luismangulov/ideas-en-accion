<?php

namespace app\controllers;

use Yii;
use app\models\PreForumThread;
use app\models\PreForumBoard;
use app\models\PreForumBoardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
Yii::setAlias('avatar', '@web/uploads/user/avatar/default/');
/**
 * PreForumBoardController implements the CRUD actions for PreForumBoard model.
 */
class PreForumBoardController extends Controller
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
     * Lists all PreForumBoard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreForumBoardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreForumBoard model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->parent_id == PreForumBoard::AS_CATEGORY) {
            return $this->render('boards', [
                'model' => $model,
                'forum' => $model->forumModel,
                'parentId' => $model->id,
            ]);
        }

        $newThread = new PreForumThread();

        if ($newThread->load(Yii::$app->request->post())) {
            $newThread->board_id = $model->id;
            if ($newThread->save()) {
                Yii::$app->db->createCommand()->update('{{%pre_forum_board}}', [
                    'updated_at' => time(),
                    'updated_by' => Yii::$app->user->id
                ], 'id=:id', [':id' => $model->id])->execute();
                return $this->refresh();
            }
        }
        
        return $this->render('view', [
            'model' => $model,
            'newThread' => $newThread,
        ]);
    }

    /**
     * Creates a new PreForumBoard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreForumBoard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PreForumBoard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PreForumBoard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PreForumBoard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreForumBoard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreForumBoard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
