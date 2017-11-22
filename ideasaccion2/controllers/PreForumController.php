<?php

namespace app\controllers;

use Yii;

use app\models\PreForumThread;
use app\models\PreForumBoard;
use app\models\PreForum;
use app\models\PreForumSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
Yii::setAlias('forum_icon', '@web/uploads/forum/icon/');
Yii::setAlias('avatar', '@web/uploads/user/avatar/default/');
Yii::setAlias('photo', '@web/uploads/home/photo/');
/**
 * PreForumController implements the CRUD actions for PreForum model.
 */
class PreForumController extends Controller
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
     * Lists all PreForum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreForumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreForum model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='equipo';
        
        if(\Yii::$app->user->can('administrador'))
        {
            $model = $this->backfindModel($id);
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == Board::AS_BOARD ) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('view', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        else
        {
    
            $model = $this->findModel($id);
            if ($model->status === PreForum::STATUS_PENDING) {
                return $this->render('status', [
                    'model' => $model
                ]);
            }
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == PreForumBoard::AS_BOARD) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('view', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        
    }

    /**
     * Creates a new PreForum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout='registrar';
        $model = new PreForum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
            //$model->status=1;
            //$model->save();
            return $this->redirect(['view', 'id' => $model->forum_url]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PreForum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $action='dashboard')
    {
        if(\Yii::$app->user->can('administrador'))
        {
            $model = $this->backfindModel($id);

            $newBoard = new PreForumBoard();
            if ($newBoard->load(Yii::$app->request->post())) {
                $newBoard->forum_id = $model->id;
                if ($newBoard->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Server error.');
                }
            }
            
            //上传上传图标
            Yii::setAlias('@upload', '@webroot/uploads/forum/icon/');
            if (Yii::$app->request->isPost && !empty($_FILES)) {
                $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $fileName = $model->id . '_' . time() . rand(1 , 10000) . '.' . $extension;
    
                Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);
                
                //删除旧图标
                if (file_exists(Yii::getAlias('@upload').$model->forum_icon) && (strpos($model->forum_icon, 'default') === false))
                    @unlink(Yii::getAlias('@upload').$model->forum_icon); 
    
                $model->forum_icon = $fileName;
                $model->update();
            }
    
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
            }
            
            return $this->render('update', [
                'model' => $model,
                'newBoard' => $newBoard,
                'action' => $action
            ]);
        }
        else
        {
            $model = $this->findModel($id);
            if ($model->user_id !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('You are not allowed to perform this action.');
            }
            if ($model->status === Forum::STATUS_PENDING) {
                return $this->render('status', [
                    'model' => $model
                ]);
            }
    
            $newBoard = new Board();
            if ($newBoard->load(Yii::$app->request->post())) {
                $newBoard->forum_id = $model->id;
                if ($newBoard->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Server error.');
                }
            }
            
            //上传图标
            Yii::setAlias('@upload', '@webroot/uploads/forum/icon/');
            if (Yii::$app->request->isPost && !empty($_FILES)) {
                $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $fileName = $model->id . '_' . time() . rand(1 , 10000) . '.' . $extension;
    
                Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);
                
                //删除旧图标
                if (file_exists(Yii::getAlias('@upload').$model->forum_icon) && (strpos($model->forum_icon, 'default') === false))
                    @unlink(Yii::getAlias('@upload').$model->forum_icon); 
    
                $model->forum_icon = $fileName;
                $model->update();
            }
    
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $cache = Yii::$app->cache;
                $cachePrefix = Yii::$app->getModule('forum')->cachePrefix;
                $cacheKey = $cachePrefix . $model->forum_url;
                $cache->set($cacheKey, $model);
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
            }
            
            return $this->render('update', [
                'model' => $model,
                'newBoard' => $newBoard,
                'action' => $action
            ]);
        }
        
    }

    /**
     * Deletes an existing PreForum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->backfindModel($id);
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deleted successfully.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error.'));
        }
        return $this->redirect(['/pre-forum/index']);
    }

    /**
     * Finds the PreForum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreForum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $cache = Yii::$app->cache;
        $cachePrefix = 'pre-forum';
        $cacheKey = $cachePrefix . $id;
        $model = $cache->get($cacheKey);
        if ($model === false) {
            if (($model = PreForum::findOne(['forum_url' => $id])) !== null) {
                $cache->set($cacheKey, $model);
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            //var_dump($model->boards[0]->threads['threads']);die;
            return $model;
        }
    }
    
    protected function backfindModel($id)
    {
        if (is_numeric($id)) {
            $model = PreForum::findOne($id);
        } else {
            $model = PreForum::find()->where(['forum_url' => $id])->one();
        }
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function newThread($id)
    {
        $newThread = new PreForumThread();
        if ($newThread->load(Yii::$app->request->post())) {
            $newThread->board_id = $id;
            $newThread->save();
            Yii::$app->db->createCommand()->update('{{%pre_forum_board}}', [
                'updated_at' => time(),
                'updated_by' => Yii::$app->user->id
            ], 'id=:id', [':id' => $id])->execute();
            $this->refresh();
        }
        return $newThread;
    }
    
    
    
    public function actionVer($id)
    {
        $this->layout='equipo';
        
        if(\Yii::$app->user->can('administrador'))
        {
            $model = $this->backfindModel($id);
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == Board::AS_BOARD ) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('ver', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        else
        {
    
            $model = $this->findModel($id);
            if ($model->status === PreForum::STATUS_PENDING) {
                return $this->render('status', [
                    'model' => $model
                ]);
            }
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == PreForumBoard::AS_BOARD) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('ver', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        
    }
    
    public function actionVer2($id)
    {
        $this->layout='equipo';
        
        if(\Yii::$app->user->can('administrador'))
        {
            $model = $this->backfindModel($id);
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == Board::AS_BOARD ) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('ver', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        else
        {
    
            $model = $this->findModel($id);
            if ($model->status === PreForum::STATUS_PENDING) {
                return $this->render('status', [
                    'model' => $model
                ]);
            }
            
            if ($model->boardCount == 1 && $model->boards[0]->parent_id == PreForumBoard::AS_BOARD) {
                $newThread = $this->newThread($model->boards[0]->id);
            } else {
                $newThread = null;
            }
            
            return $this->render('ver2', [
                'model' => $model,
                'newThread' => $newThread,
            ]);
        }
        
    }
}
