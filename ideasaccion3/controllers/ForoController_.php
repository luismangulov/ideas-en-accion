<?php

namespace app\controllers;

use Yii;
use app\models\Foro;
use app\models\ForoSearch;
use app\models\ForoComentario;
use app\models\Proyecto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ForoController implements the CRUD actions for Foro model.
 */
class ForoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Foro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ForoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Foro model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='estandar';
        $newComentario = new ForoComentario();
        $model=$this->findModel($id);
        /*$foro=Foro::find()->where('id=:id and id<=34',[':id'=>$model->id])->one();
        if($foro)
        {
            
        }*/
        
        
        if ($newComentario->load(Yii::$app->request->post())) {
            $newComentario->foro_id = $model->id;
            if ($newComentario->save()){
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('view', [
            'model' => $model,
            'newComentario'=>$newComentario
        ]);
    }
    
    public function actionViewadmin($id)
    {
        $this->layout='administrador';
        $newComentario = new ForoComentario();
        $model=$this->findModel($id);
        if ($newComentario->load(Yii::$app->request->post())) {
            
            $newComentario->foro_id = $model->id;
            //var_dump($newComentario->foro_id);die;
            if ($newComentario->save()){
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return $this->redirect(['viewadmin', 'id' => $model->id]);
            }
        }
        
        return $this->render('viewadmin', [
            'model' => $model,
            'newComentario'=>$newComentario
        ]);
    }

    /**
     * Creates a new Foro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Foro();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Foro model.
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
     * Deletes an existing Foro model.
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
     * Finds the Foro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Foro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Foro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionProyecto($id)
    {
        $this->layout='estandar';
        $newComentario = new ForoComentario();
        $model=$this->findModel($id);
        $seccion=new Proyecto;
        $seccion->load(Yii::$app->request->queryParams);
        
        if ($newComentario->load(Yii::$app->request->post())) {
            $newComentario->seccion=$seccion->seccion;
            $newComentario->foro_id = $model->id;
            if ($newComentario->save()){
                return $this->refresh();
            }
        }
        
        return $this->render('proyecto', [
            'model' => $model,
            'newComentario'=>$newComentario
        ]);
    }
    
    public function actionProyectoMonitor($id)
    {
        $this->layout='administrador';
        $newComentario = new ForoComentario();
        $model=$this->findModel($id);
        $seccion=new Proyecto;
        $seccion->load(Yii::$app->request->queryParams);
        
        if ($newComentario->load(Yii::$app->request->post())) {
            $newComentario->seccion=$seccion->seccion;
            $newComentario->foro_id = $model->id;
            if ($newComentario->save()){
                return $this->refresh();
            }
        }
        
        return $this->render('proyecto-monitor', [
            'model' => $model,
            'newComentario'=>$newComentario
        ]);
    }
    
    public function actionProyectoMonitorVotacion($id)
    {
        $this->layout='administrador';
        //$model=$this->findModel($id);
        return $this->render('proyecto-monitor-votacion', [
            'id' => $id
        ]);
    }
}
