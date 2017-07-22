<?php

namespace app\controllers;

use Yii;
use app\models\Voto;
use app\models\VotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use app\models\VotacionPublica;
use app\models\VotacionFinal;
use app\models\Ubigeo;
use app\models\Estudiante;
/**
 * VotoController implements the CRUD actions for Voto model.
 */
Yii::setAlias('video', '@web/video_carga/');
class VotoController extends Controller
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
     * Lists all Voto models.
     * @return mixed
     */
    /*
    public function actionIndex()
    {
        $searchModel = new VotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Voto model.
     * @param integer $asunto_id
     * @param string $region_id
     * @param integer $participante_id
     * @return mixed
     */
    /*
    public function actionView($asunto_id, $region_id, $participante_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($asunto_id, $region_id, $participante_id),
        ]);
    }

    /**
     * Creates a new Voto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
    public function actionCreate()
    {
        $model = new Voto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'asunto_id' => $model->asunto_id, 'region_id' => $model->region_id, 'participante_id' => $model->participante_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Voto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $asunto_id
     * @param string $region_id
     * @param integer $participante_id
     * @return mixed
     */
    /*
    public function actionUpdate($asunto_id, $region_id, $participante_id)
    {
        $model = $this->findModel($asunto_id, $region_id, $participante_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'asunto_id' => $model->asunto_id, 'region_id' => $model->region_id, 'participante_id' => $model->participante_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Voto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $asunto_id
     * @param string $region_id
     * @param integer $participante_id
     * @return mixed
     */
    /*
    public function actionDelete($asunto_id, $region_id, $participante_id)
    {
        $this->findModel($asunto_id, $region_id, $participante_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Voto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $asunto_id
     * @param string $region_id
     * @param integer $participante_id
     * @return Voto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($asunto_id, $region_id, $participante_id)
    {
        if (($model = Voto::findOne(['asunto_id' => $asunto_id, 'region_id' => $region_id, 'participante_id' => $participante_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionValidardni($dni)
    {
        $dni=Voto::find()->where('participante_id=:dni',[':dni'=>$dni])->one();
        if($dni)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    
    public function actionRegistrar()
    {
        return $this->redirect(['site/resultados']); //cambiar a subir a produccion
        $dni=$_GET['Voto']['dni'];
        $region=$_GET['Voto']['region'];
        $asuntos=$_GET['Asuntos'];
        $Countdni=strlen(trim($_GET['Voto']['dni']));
        $Countasuntos=count($_GET['Asuntos']);
        
        $validandodni=Voto::find()->where('participante_id=:participante_id',[':participante_id'=>$dni])->all();
        if(!$validandodni && is_numeric($dni) && $Countdni==8 && $Countasuntos==3)
        {
            foreach($asuntos as $asunto => $key)
            {
                $voto=new Voto;
                $voto->participante_id=$dni;
                $voto->dni=$region;
                $voto->region_id=$region;
                $voto->asunto_id=$key;
                $voto->fecha_registro=date("Y-m-d H:i:s");
                $voto->estado=1;
                $voto->save();
                
            }
            $bandera=1;
        }
        else{
            $bandera=0;
        }
        echo $bandera;
        
    }
    
    
    public function actionResultados($region)
    {
        $div="";
        $resultados=Voto::find()
                    ->limit(3)
                    ->select(['asunto.descripcion_corta','asunto.descripcion_cabecera as asuntod','asunto_id','COUNT(asunto_id) contador'])
                    ->innerJoin('asunto','voto.asunto_id=asunto.id')
                    ->where('region_id=:region_id',[':region_id'=>$region])
                    ->groupBy('asuntod ,asunto_id')
                    ->orderBy('contador desc ')
                    ->all();
        $total=Voto::find()->select(['COUNT(asunto_id) contador'])
                    ->where('region_id=:region_id',[':region_id'=>$region])
                    ->one();
        $departamento=Ubigeo::find()
                        ->select('department')
                        ->distinct()
                        ->where('department_id=:department_id',[':department_id'=>$region])
                        //->groupBy('department')
                        ->one();
        
        $div="
            <div class=\"text_deparment\">
		Región <span>$departamento->department</span>
            </div>
            <div class=\"row result_map\">
            <table width=\"100%\">";
        $total=0;
        
        foreach($resultados as $resultado)
        {
            $total=$total+$resultado->contador;
        }
        
        foreach($resultados as $resultado)
        {
                                                
            $div=$div."     <tr>
                                <td width=\"60%\" class=\"ia_left\"><span class=\"ia_icon_heart_small\">".$resultado->asuntod."<p style='font-size:13px'>".$resultado->descripcion_corta."</p></span></td>
                                <td class=\"ia_right\" align=\"middle\">
                                    <div class=\"show_percent\">
                                        <div class=\"percent_bar\" style=\"width:".number_format((($resultado->contador*100)/$total), 1, '.', '')."%;\"></div>
                                    </div>".number_format((($resultado->contador*100)/$total), 1, '.', '')."%
                                </td>
                            </tr>";
        }
        
        $div=$div."</table></div>";
        
        echo $div;
        
        
    }
    
    
    public function actionResultadoslima($region)
    {
        $div="";
        $resultados=Voto::find()
                    ->limit(3)
                    ->select(['asunto.descripcion_cabecera as asuntod','asunto_id','COUNT(asunto_id) contador'])
                    ->innerJoin('asunto','voto.asunto_id=asunto.id')
                    ->where('region_id=:region_id',[':region_id'=>$region])
                    ->groupBy('asuntod ,asunto_id')
                    ->orderBy('contador desc ')
                    ->all();
        $total=Voto::find()->select(['COUNT(asunto_id) contador'])
                    ->where('region_id=:region_id',[':region_id'=>$region])
                    ->one();
        $departamento=Ubigeo::find()
                        ->select('department')
                        ->distinct()
                        ->where('department_id=:department_id',[':department_id'=>$region])
                        //->groupBy('department')
                        ->one();
        
        $div="
            <table width=\"100%\">";
        $total=0;
        
        foreach($resultados as $resultado)
        {
                                                
            $total=$total+$resultado->contador;
        }
        
        
        foreach($resultados as $resultado)
        {
                                                
            $div=$div." <tr>
                                <td width=\"60%\" class=\"ia_left\"><span class=\"ia_icon_heart_small\">".$resultado->asuntod."</span></td>
                                <td class=\"ia_right\" align=\"middle\">
                                    <div class=\"show_percent\">
                                        <div class=\"percent_bar\" style=\"width:".number_format((($resultado->contador*100)/$total), 1, '.', '')."%;\"></div>
                                    </div>".number_format((($resultado->contador*100)/$total), 1, '.', '')."%
                                </td>
                            </tr>";
        }
        
        $div=$div."</table>";
        
        echo $div;
        
        
    }
    
    public function actionMostrarvotacionpublica($region)
    {
        if($region=="amazonas")
        {
            $region="01";
        }
        elseif($region=="ancash")
        {
            $region="02";
        }
        elseif($region=="apurimac")
        {
            $region="03";
        }
        elseif($region=="arequipa")
        {
            $region="04";
        }
        elseif($region=="ayacucho")
        {
            $region="05";
        }
        elseif($region=="cajamarca")
        {
            $region="06";
        }
        elseif($region=="callao")
        {
            $region="07";
        }
        elseif($region=="cuzco")
        {
            $region="08";
        }
        elseif($region=="huancavelica")
        {
            $region="09";
        }
        elseif($region=="huanuco")
        {
            $region="10";
        }
        elseif($region=="ica")
        {
            $region="11";
        }
        elseif($region=="junin")
        {
            $region="12";
        }
        elseif($region=="la_libertad")
        {
            $region="13";
        }
        elseif($region=="lambayeque")
        {
            $region="14";
        }
        elseif($region=="lima")
        {
            $region="15";
        }
        elseif($region=="loreto")
        {
            $region="16";
        }
        elseif($region=="madre_de_dios")
        {
            $region="17";
        }
        elseif($region=="moquegua")
        {
            $region="18";
        }
        elseif($region=="pasco")
        {
            $region="19";
        }
        elseif($region=="piura")
        {
            $region="20";
        }
        elseif($region=="puno")
        {
            $region="21";
        }
        elseif($region=="san_martin")
        {
            $region="22";
        }
        elseif($region=="tacna")
        {
            $region="23";
        }
        elseif($region=="tumbes")
        {
            $region="24";
        }
        elseif($region=="ucayali")
        {
            $region="25";
        }
        elseif($region=="lima_provincias")
        {
            $region="26";
        }
        
        
        $htmlvotacionespublicas='';
        $i=0;
        $votacionespublicas=VotacionPublica::find()
                        ->select(['votacion_publica.proyecto_id','proyecto.titulo','proyecto.resumen','institucion.denominacion','equipo.id as equipo_id','video.tipo','video.ruta','(select count(proyecto_id) from votacion_final where proyecto_id=proyecto.id) as votos'])
                        ->innerJoin('proyecto','proyecto.id=votacion_publica.proyecto_id')
                        ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                        ->innerJoin('video','video.proyecto_id=proyecto.id and video.etapa=2')
                        ->innerJoin('usuario','usuario.id=proyecto.user_id')
                        ->innerJoin('estudiante','estudiante.id=usuario.estudiante_id')
                        ->innerJoin('institucion','institucion.id=estudiante.institucion_id')
                        ->where('votacion_publica.region_id=:region_id',[':region_id'=>$region])
                        ->orderBy('votos desc')
                        ->all();
                        //var_dump($region);
        if($region==15)
        {
            $htmlvotacionespublicas=$htmlvotacionespublicas.'
                                                            <div class="form-group">
                                                                <select id="lima-lima" class="form-control">
                                                                    <option>Seleccionar</option>
                                                                    <option value="07">Callao</option>
                                                                    <option value="15">Lima Metropolitana</option>
                                                                    <option value="26">Lima Provincias</option>
                                                                </select>
                                                            </div>
                                                            <div id="lima-resultados"></div>
                                                            ';
        }
        else
        {
            foreach($votacionespublicas as $resultado)
            {
                $class="vote_icon_map";
                $classvoto="box_option_voto";
                $finalista="";
                $style="";
                if($i==0)
                {
                    $class="vote_icon_map_ganador";
                    $classvoto="box_option_voto_ganador";
                    $finalista="<br><b style='font-size: 9px'>Finalista</b>";
                    $style="background:white";
                }
                $htmlvotacionespublicas=$htmlvotacionespublicas.'
                                        <div id="v_'.$resultado->proyecto_id.'" data-id="'.$resultado->proyecto_id.'" class="'.$classvoto.'">
                                            <div class="box-head-voto">
                                                    <div class="row">
                                                            <div class="col-md-7 bhb_left">
                                                                '.$resultado->titulo.'
                                                                '.$finalista.'
                                                            </div>
                                                            <div class="col-md-5 bhb_right">
                                                                    '.VotacionFinal::find()->select('proyecto_id')->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$resultado["proyecto_id"]])->count().' votos <span class="'.$class.'"></span>
                                                            </div>
                                                    </div>
                                            </div>
    
                                            <div class="box-body-voto" style="'.$style.'">
                                                <b>Resumen:</b><br>
                                                <p class="text-justify">'.$resultado->resumen.'</p>
                                                <div class="line_yellow"></div>
                                                <b>IIEE:</b><br>
                                                '.$resultado->denominacion.'
                                                <div class="line_yellow"></div>
                                                <b>Equipo:</b><br>';
                                                
                                                $integrantes=Estudiante::find()
                                                            ->select('nombres,apellido_paterno,apellido_materno')
                                                            ->innerJoin('integrante','estudiante.id=integrante.estudiante_id')
                                                            ->where('estudiante.grado!=6 and integrante.equipo_id=:equipo_id',[':equipo_id'=>$resultado->equipo_id])
                                                            ->all();
                                             
                                                foreach($integrantes as $integrante){
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'- '.$integrante->nombres.' '.$integrante->apellido_paterno.' '.$integrante->apellido_materno.'<br>';
                                                }
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<b>Docente asesor</b><br>';
                                               
                                                $docente=Estudiante::find()
                                                            ->select('nombres,apellido_paterno,apellido_materno')
                                                            ->innerJoin('integrante','estudiante.id=integrante.estudiante_id')
                                                            ->where('estudiante.grado=6 and integrante.equipo_id=:equipo_id',[':equipo_id'=>$resultado->equipo_id])
                                                            ->one();
                                                
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'-'.$docente->nombres.' '.$docente->apellido_paterno.' '.$docente->apellido_materno.'<br>';
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<div class="line_yellow"></div>';
                                                if($resultado->tipo==1){
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'<iframe width="300" height="169" src="https://www.youtube.com/embed/'.substr($resultado->ruta,-11).'" frameborder="0" allowfullscreen></iframe>';
                                                }else{
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'<video width="320" height="169" controls>';
                                                       $htmlvotacionespublicas=$htmlvotacionespublicas.'<source src="'.Yii::getAlias('@video').$resultado->ruta.'" >';  
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'</video>';
                                                }
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<div class="line_yellow"></div>
                                                <div class="end_body_voto">
                                                <!--
                                                        Pasa la voz a tu mancha
                                                        <a href="#" class="share_fb"
							data-project="'.$resultado->titulo.'"
							data-image="http://face.ideasenaccion.pe/images/logo_for_fb.jpg"
							data-link="http://votacion.ideasenaccion.pe/votacion-publica">
								<img src="'.\Yii::$app->request->BaseUrl.'/votacion/images/icon_fb_normal.png" alt="">
							</a>
                                                        -->
                                                </div>
                                            </div>
                                        </div>';
                $i++;
            }
        }
        echo $htmlvotacionespublicas;
    
    }
    
    
    public function actionMostrarvotacionpublicalima($region)
    {
        if($region=="callao")
        {
            $region="07";
        }
        elseif($region=="lima")
        {
            $region="15";
        }
        elseif($region=="lima_provincias")
        {
            $region="26";
        }
        
        
        $htmlvotacionespublicas='';
        $i=0;
        $votacionespublicas=VotacionPublica::find()
                        ->select(['votacion_publica.proyecto_id','proyecto.titulo','proyecto.resumen','institucion.denominacion','equipo.id as equipo_id','video.tipo','video.ruta','(select count(proyecto_id) from votacion_final where proyecto_id=proyecto.id) as votos'])
                        ->innerJoin('proyecto','proyecto.id=votacion_publica.proyecto_id')
                        ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                        ->innerJoin('video','video.proyecto_id=proyecto.id and video.etapa=2')
                        ->innerJoin('usuario','usuario.id=proyecto.user_id')
                        ->innerJoin('estudiante','estudiante.id=usuario.estudiante_id')
                        ->innerJoin('institucion','institucion.id=estudiante.institucion_id')
                        ->where('votacion_publica.region_id=:region_id',[':region_id'=>$region])
                        ->orderBy('votos desc')
                        ->all();
                        //var_dump($region);
        
            foreach($votacionespublicas as $resultado)
            {
                $class="vote_icon_map";
                $classvoto="box_option_voto";
                $finalista="";
                $style="";
                if($i==0)
                {
                    $class="vote_icon_map_ganador";
                    $classvoto="box_option_voto_ganador";
                    $finalista="<br><b style='font-size: 9px'>Finalista</b>";
                    $style="background:white";
                }
                
                
                $htmlvotacionespublicas=$htmlvotacionespublicas.'
                                        <div id="v_'.$resultado->proyecto_id.'" data-id="'.$resultado->proyecto_id.'" class="'.$classvoto.'">
                                            <div class="box-head-voto">
                                                    <div class="row">
                                                            <div class="col-md-7 bhb_left">
                                                                '.strtoupper($resultado->titulo).'
                                                                '.$finalista.'
                                                                
                                                            </div>
                                                            <div class="col-md-5 bhb_right">
                                                                    '.VotacionFinal::find()->select('proyecto_id')->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$resultado["proyecto_id"]])->count().' votos <span class="'.$class.'"></span>
                                                            </div>
                                                    </div>
                                            </div>
    
                                            <div class="box-body-voto" style="'.$style.'">
                                                <b>Resumen:</b><br>
                                                <p class="text-justify">'.$resultado->resumen.'</p>
                                                <div class="line_yellow"></div>
                                                <b>IIEE:</b><br>
                                                '.$resultado->denominacion.'
                                                <div class="line_yellow"></div>
                                                <b>Equipo:</b><br>';
                                                
                                                $integrantes=Estudiante::find()
                                                            ->select('nombres,apellido_paterno,apellido_materno')
                                                            ->innerJoin('integrante','estudiante.id=integrante.estudiante_id')
                                                            ->where('estudiante.grado!=6 and integrante.equipo_id=:equipo_id',[':equipo_id'=>$resultado->equipo_id])
                                                            ->all();
                                             
                                                foreach($integrantes as $integrante){
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'- '.$integrante->nombres.' '.$integrante->apellido_paterno.' '.$integrante->apellido_materno.'<br>';
                                                }
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<b>Docente asesor</b><br>';
                                               
                                                $docente=Estudiante::find()
                                                            ->select('nombres,apellido_paterno,apellido_materno')
                                                            ->innerJoin('integrante','estudiante.id=integrante.estudiante_id')
                                                            ->where('estudiante.grado=6 and integrante.equipo_id=:equipo_id',[':equipo_id'=>$resultado->equipo_id])
                                                            ->one();
                                                
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'-'.$docente->nombres.' '.$docente->apellido_paterno.' '.$docente->apellido_materno.'<br>';
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<div class="line_yellow"></div>';
                                                if($resultado->tipo==1){
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'<iframe width="300" height="169" src="https://www.youtube.com/embed/'.substr($resultado->ruta,-11).'" frameborder="0" allowfullscreen></iframe>';
                                                }else{
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'<video width="320" height="169" controls>';
                                                       $htmlvotacionespublicas=$htmlvotacionespublicas.'<source src="'.Yii::getAlias('@video').$resultado->ruta.'" >';  
                                                    $htmlvotacionespublicas=$htmlvotacionespublicas.'</video>';
                                                }
                                                $htmlvotacionespublicas=$htmlvotacionespublicas.'<div class="line_yellow"></div>
                                                <div class="end_body_voto">
                                                <!--
                                                        Pasa la voz a tu mancha
                                                        <a href="#" class="share_fb"
							data-project="'.$resultado->titulo.'"
							data-image="http://face.ideasenaccion.pe/images/logo_for_fb.jpg"
							data-link="http://votacion.ideasenaccion.pe/votacion-publica">
								<img src="'.\Yii::$app->request->BaseUrl.'/votacion/images/icon_fb_normal.png" alt="">
							</a>
                                                        -->
                                                </div>
                                            </div>
                                        </div>';
                $i++;
            }
            
        echo $htmlvotacionespublicas;
    
    }
    
    public function actionValidardnivotacionpublica($dni)
    {
        $dni=VotacionFinal::find()->where('dni=:dni',[':dni'=>$dni])->one();
        if($dni)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    
    public function actionVotacionfinal($dni,$proyecto)
    {
        $votacionfinal=new VotacionFinal;
        $votacionfinal->dni=$dni;
        $votacionfinal->proyecto_id=$proyecto;
        $votacionfinal->estado=1;
        $votacionfinal->save();
        echo 1;
    }
}
