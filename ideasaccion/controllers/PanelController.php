<?php

namespace app\controllers;

use Yii;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Integrante;
use app\models\Usuario;
use app\models\Voto;
use app\models\Foro;
use app\models\Asunto;
use app\models\Ubigeo;
use app\models\Participante;
use app\models\Invitacion;
use app\models\ParticipanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Resultados;
use app\models\Etapa;
use app\models\VotacionInternaSearch;
use app\models\VotacionInterna;
use app\models\VotacionPublica;
use app\models\Proyecto;
use app\models\ForoComentario;
use app\models\Institucion;
use app\models\Inscripcion;
use app\models\ProyectoCopia;
use app\models\Video;
use yii\data\Sort;

/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class PanelController extends Controller {

    public function behaviors() {
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
     * Lists all Participante models.
     * @return mixed
     */
    public function actionRegistro() {
        $this->layout = 'ideasregistro';
        $msg = "! Felicitaciones por tu esfuerzo.<br>
                        Si bien no pasaste a la siguiente etapa,<br>
                        te invitamos a participar de los foros<br>
                        y <b>¡seguir poniendo tus ideas en acción!</b>.";
        if (\Yii::$app->user->can('administrador')) {
            //session_start();
                //$_SESSION["rol"] = "ADMINISTRADOR";
               
            
            return $this->redirect(['panel/acciones']);
        } elseif (\Yii::$app->user->can('monitor')) {
            return $this->redirect(['reporte/index']);
        } else {
            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
            if ($integrante) {
                $equipo = Equipo::findOne($integrante->equipo_id);
                if ($equipo && $equipo->etapa == 1) {
                    /* $msg="  ¡Felicitaciones!<br>
                      Tú y tu equipo pasaron a la siguiente etapa<br>
                      Ahora deben dar aportes a otros proyectos<br>
                      y mejorar su proyecto<br>
                      No te olvides de hacer tu video de la primera actividad.<br>
                      <b>¡Sigue poniendo tus ideas en acción!</b>"; */
                    $msg = "  ¡Te felicitamos por tu participación en Ideas en acción!";
                } elseif ($equipo && $equipo->etapa == 2) {
                    $proyectoCopia = ProyectoCopia::find()->where('equipo_id=:equipo_id and etapa=2', [':equipo_id' => $equipo->id])->one();
                    if ($proyectoCopia) {
                        $msg = "  ¡Hola! Felicitaciones por haber pasado a esta nueva etapa del concurso. Recuerda que tú y los<br>
                            integrantes de tu equipo deben realizar tres votos para elegir a los proyectos de tu región<br>
                            <b>¡Sigue en la ruta!</b>";
                    } else {
                        $msg = "  ¡Te felicitamos por tu participación en Ideas en acción!";
                    }
                } elseif ($equipo && ($equipo->etapa == 0 || $equipo->etapa == NULL)) {
                    $msg = "! Felicitaciones por tu esfuerzo.<br>
                        Si bien no pasaste a la siguiente etapa,<br>
                        te invitamos a participar de los foros<br>
                        y ¡seguir poniendo tus ideas en acción!.";
                }
            }
        }


        return $this->render('registrar', ['msg' => $msg]);
    }

    /**
     * Lists all Participante models.
     * @return mixed
     */
    public function actionIdeasAccion() {
        $this->layout = 'ideas';
        $msg = "¡Felicidades! Ya estás inscrito, avísale a tu coordinador para que conforme el equipo. ";
        /* $msg=           "3 Felicitaciones por tu esfuerzo.<br>
          Si bien no pasaste a la siguiente etapa,<br>
          te invitamos a participar de los foros<br>
          y <b>¡seguir poniendo tus ideas en acción!</b>.";
         */
        if (\Yii::$app->user->can('administrador')) {
            //$_SESSION["rol"] = "ADMINISTRADOR";
            return $this->redirect(['panel/acciones']);
        } elseif (\Yii::$app->user->can('monitor')) {
            return $this->redirect(['reporte/index']);
        } else {
            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
            if ($integrante) {
                $equipo = Equipo::findOne($integrante->equipo_id);
                if ($equipo && $equipo->etapa == 1) {
                    /* $msg="  ¡Felicitaciones!<br>
                      Tú y tu equipo pasaron a la siguiente etapa<br>
                      Ahora deben dar aportes a otros proyectos<br>
                      y mejorar su proyecto<br>
                      No te olvides de hacer tu video de la primera actividad.<br>
                      <b>¡Sigue poniendo tus ideas en acción!</b>"; */
                    $msg = "  ¡Te felicitamos por tu participación en Ideas en acción! ";
                } elseif ($equipo && $equipo->etapa == 2) {
                    $proyectoCopia = ProyectoCopia::find()->where('equipo_id=:equipo_id and etapa=2', [':equipo_id' => $equipo->id])->one();
                    if ($proyectoCopia) {
                        $msg = "  ¡Hola! Felicitaciones por haber pasado a esta nueva etapa del concurso. Recuerda que tú y los<br>
                            integrantes de tu equipo deben realizar tres votos para elegir a los proyectos de tu región<br>
                            <b>¡Sigue en la ruta!</b>";
                    } else {
                        $msg = "  ¡Te felicitamos por tu participación en Ideas en acción";
                    }
                } elseif ($equipo && ($equipo->etapa == 0 || $equipo->etapa == NULL) && $equipo->estado == 0) {
                    $msg = "¡Qué esperas!  Recuerda que tienes hasta el 14 de agosto para inscribirte con tu equipo y poner sus… IDEAS EN ACCIÓN";
                } elseif ($equipo && ($equipo->etapa == 0 || $equipo->etapa == NULL) && $equipo->estado == 1) {
                    $msg = "¡¡Perfecto!  El equipo ya está conformado, ahora sí llego el momento de poner sus… Ideas en Acción!!! ";
                }
            }
        }


        return $this->render('ideas-accion', ['msg' => $msg]);
    }

    public function actionIndex() {
        $this->layout = 'panel';
        if (\Yii::$app->user->can('administrador')) {
           // $_SESSION["rol"] = "ADMINISTRADOR";
            return $this->redirect(['panel/acciones']);
        } elseif (\Yii::$app->user->can('monitor')) {
            return $this->redirect(['reporte/index']);
        }


        $usuario = Usuario::findOne(\Yii::$app->user->id);
        // $usuario = Usuario::find()->where("id=:estudiante_id and status_registro=2", [':estudiante_id' => $usuario->estudiante_id])->one();
        if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador" || $usuario->status_registro == "1") {
            return $this->goHome();
        }


        //$usuario=Usuario::findOne(\Yii::$app->user->id);
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
        $institucion = Institucion::find()->where('id=:id', [':id' => $estudiante->institucion_id])->one();
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
        if ($integrante) {
            $equipo = Equipo::findOne($integrante->equipo_id);
            if ($equipo->foto == "") {
                $equipo->foto = "no_disponible.png";
            }
        } else {
            $equipo = new Equipo;
        }

        $estudiantes = Estudiante::find()
                        ->LeftJoin('integrante', 'integrante.estudiante_id=estudiante.id')
                        ->where('estudiante.institucion_id=:institucion_id and estudiante.id!=:id and integrante.id is null and estudiante.grado!=6
                            ', [':institucion_id' => $institucion->id, ':id' => $estudiante->id])
                        ->orderBy('grado asc')->all();

        $invitaciones = Invitacion::find()
                ->select('usuario.avatar,invitacion.id,equipo.descripcion_equipo,lider.nombres,lider.apellido_paterno,lider.apellido_materno,lider.nombres_apellidos,institucion.denominacion')
                ->innerJoin('equipo', 'equipo.id=invitacion.equipo_id')
                ->innerJoin('estudiante lider', 'invitacion.estudiante_id=lider.id')
                ->innerJoin('usuario', 'usuario.estudiante_id=lider.id')
                ->innerJoin('institucion', 'institucion.id=lider.institucion_id')
                ->where('invitacion.estudiante_invitado_id=:invitado and invitacion.estado=1', [':invitado' => $usuario->estudiante_id])
                ->all();



        return $this->render('index', ['invitaciones' => $invitaciones,
                    'integrante' => $integrante,
                    'estudiante' => $estudiante,
                    'equipo' => $equipo,
                    'estudiantes' => $estudiantes
        ]);
    }

    public function actionAcciones() {

        if (!\Yii::$app->user->can('administrador')) {
            return $this->redirect(['login/logout']);
        }/*else{
            $_SESSION["rol"] = "ADMINISTRADOR";
        }*/



        $this->layout = 'administrador';
        $countVoto = 1;
        //$countVoto = Voto::find()->count();
        $resultados = Resultados::find()->all();
        $Countresultados = Resultados::find()->count();
        $votacionpublica = VotacionPublica::find()->all();
        $etapa = Etapa::find()->where('estado=1')->one();
        $votacionesinternas = VotacionInterna::find()->count();
        $faltavalorporcentual = VotacionInterna::find()
                        ->innerJoin('proyecto', 'proyecto.id=votacion_interna.proyecto_id')
                        ->where('votacion_interna.estado=2 and proyecto.valor_porcentual_administrador is null ')->count();

        return $this->render('acciones', ['resultados' => $resultados, 'etapa' => $etapa,
                    'faltavalorporcentual' => $faltavalorporcentual,
                    'votacionpublica' => $votacionpublica,
                    'countVoto' => $countVoto, 'Countresultados' => $Countresultados,
                    'votacionesinternas' => $votacionesinternas]);
    }

    public function actionCerrar($bandera) {
        $resultados = Resultados::find()->all();
        $connection = \Yii::$app->db;
        $ubigeos = Ubigeo::find()->select('department_id,department')->groupBy('department_id')->orderBy('department desc')->all();
        if ($bandera == 1 && !$resultados) {
            foreach ($ubigeos as $ubigeo) {
                $command = $connection->createCommand("
                    insert into resultados (asunto_id,region_id,cantidad)
                    select asunto_id,region_id,COUNT(asunto_id) contador from voto
                    where region_id='$ubigeo->department_id'
                    group by region_id,asunto_id
                    order by contador desc
                    limit 3;
                ");

                $command->execute();
            }
            echo 1;
        } else {
            echo 2;
        }
    }

    public function actionVotacioninterna() {
        $this->layout = 'administrador';

        $searchModel = new VotacionInternaSearch();
        $dataProvider = $searchModel->votacion(Yii::$app->request->queryParams);
        $countInterna = VotacionInterna::find()->select(['count(proyecto_id) as maximo'])
                        ->where('estado=2')
                        ->groupBy('proyecto_id')->orderBy('maximo desc')->one();

        return $this->render('votacioninterna', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'countInterna' => $countInterna]);
    }

    public function actionForos() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $forospublicos = Foro::find()
                ->select([
                    'foro.id',
                    'foro.titulo',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                ])
                ->innerJoin('asunto', 'foro.asunto_id=asunto.id')
                //->innerJoin('resultados','resultados.asunto_id=foro.asunto_id')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->all();

        $foroparticipacion = Foro::find()
                ->select([
                    'foro.id',
                    'foro.titulo',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                ])
                ->where('foro.id=2')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->one();
        $resultado = new Resultados;
        $resultado->load(Yii::$app->request->queryParams);

        $sort = new Sort([
            'attributes' => [
            /* 'department' => [
              'label' => 'Región',
              ],
              'total_estudiantes' => [
              'label' => 'Total',
              ], */
            ],
        ]);

        return $this->render('foros', ['resultado' => $resultado, 'sort' => $sort, 'forospublicos' => $forospublicos, 'foroparticipacion' => $foroparticipacion]);
    }

    public function actionResultadosasuntospublicos($asunto) {
        $data = [];

        //var_dump($asunto);
        /* $proyectos= Proyecto::find()
          ->select([
          'proyecto.titulo',
          '(select count(foro_comentario.id) from foro_comentario
          inner join usuario on usuario.id=foro_comentario.user_id
          inner join integrante on integrante.estudiante_id=usuario.estudiante_id
          where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion!=0) as valorados',
          '(select count(foro_comentario.id) from foro_comentario
          inner join usuario on usuario.id=foro_comentario.user_id
          inner join integrante on integrante.estudiante_id=usuario.estudiante_id
          where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion=0) as faltan_valorar'])
          ->innerJoin('asunto','asunto.id=proyecto.asunto_id')
          ->innerJoin('foro','foro.asunto_id=asunto.id')
          ->where('foro.asunto_id=:asunto_id',[':asunto_id'=>$asunto])
          ->groupBy('proyecto.titulo,valorados,faltan_valorar')
          ->orderBy('valorados desc,proyecto.id asc')
          ->all(); */
        $connection = \Yii::$app->db;
        $proyectos = $connection->createCommand('
                    select 
                        proyecto.titulo,
                        (select count(foro_comentario.id) from foro_comentario 
                        inner join usuario on usuario.id=foro_comentario.user_id 
                        inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                        where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion!=0) as valorado,
                        (select count(foro_comentario.id) from foro_comentario 
                        inner join usuario on usuario.id=foro_comentario.user_id 
                        inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                        where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion=0) as falta_valorar
                    from proyecto
                    inner join asunto on asunto.id=proyecto.asunto_id
                    inner join foro on foro.asunto_id=asunto.id 
                    where foro.asunto_id=' . $asunto . '
                    group by proyecto.titulo,valorado,falta_valorar
                    order by valorado desc,proyecto.id asc')
                ->queryAll();

        foreach ($proyectos as $proyecto) {
            array_push($data, ['titulo' => $proyecto["titulo"], 'valorado' => $proyecto["valorado"], 'falta_valorar' => $proyecto["falta_valorar"]]);
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function actionRating($rating, $comentario_id) {
        $foro_comentario = ForoComentario::findOne($comentario_id);
        $foro_comentario->valoracion = $rating;
        $foro_comentario->update();
    }

    public function actionForosproyectos() {
        $this->layout = 'administrador';


        return $this->render('forosproyectos', []);
    }

    public function actionResultadosproyectos($region) {
        $data = [];
        $connection = \Yii::$app->db;

        $forosproyectos = Foro::find()
                ->select([
                    'foro.id',
                    'foro.titulo',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total_comentario',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0) falta_valorar',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado'
                ])
                ->innerJoin('proyecto', 'proyecto.id=foro.proyecto_id')
                ->where('proyecto.region_id=:region_id', [':region_id' => $region])
                ->groupBy('foro.titulo,total_comentario')
                ->orderBy('id desc,total_comentario DESC,falta_valorar DESC,valorado DESC')
                ->all();

        foreach ($forosproyectos as $proyecto) {
            array_push($data, ['titulo' => $proyecto["titulo"], 'total_comentario' => $proyecto["total_comentario"], 'falta_valorar' => $proyecto["falta_valorar"], 'valorado' => $proyecto["valorado"], 'foro' => $proyecto["id"]]);
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /*
      public function actionProceso()
      {

      $inscripciones=Inscripcion::find()->all();
      foreach($inscripciones as $inscripcion){
      $texto="";
      $institucion=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$inscripcion->codigo_modular])->one();
      if($institucion){
      $dni=Estudiante::find()->where('dni=:dni',[':dni'=>$inscripcion->dni])->one();
      $email=Estudiante::find()->where('email=:email',[':email'=>$inscripcion->email])->one();
      $Cantidadestudiante=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->count();
      $duplicados=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->all();
      if(!$dni)
      {
      $texto=$texto."No;";
      }
      else
      {
      $texto=$texto."Si;";
      }

      if(!$email)
      {
      $texto=$texto."No;";
      }
      else
      {
      $texto=$texto."Si;";
      }

      if($Cantidadestudiante>=2)
      {
      $texto=$texto."Si;";
      }
      else
      {
      $texto=$texto."No;";
      }
      /*if($Cantidadestudiante>=2)
      {
      $txt="";
      foreach($duplicados as $duplicado)
      {
      $txt=$txt."    Si    Datos dni:".$duplicado->dni.", correo:".$duplicado->email."xxx";
      }
      $texto=$texto.$txt.";;;";
      }
      elseif($Cantidadestudiante==1 && $dni)
      {
      $institucion=Institucion::find()->where('id=:id',[':id'=>$dni->institucion_id])->one();
      $texto=$texto."Si;".$institucion->codigo_modular.";".$institucion->denominacion.";".$dni->nombres." ".$dni->apellido_paterno." ".$dni->apellido_materno.";".$dni->dni.";".$dni->email;
      }
      elseif($Cantidadestudiante==1 && $email)
      {
      $institucion=Institucion::find()->where('id=:id',[':id'=>$email->institucion_id])->one();
      $texto=$texto."Si;".$institucion->codigo_modular.";".$institucion->denominacion.";".$email->nombres." ".$email->apellido_paterno." ".$email->apellido_materno.";".$email->dni.";".$email->email;
      }
      else
      {
      $texto=$texto."Si;No";
      }

      }
      else
      {
      $texto=$texto."No;No;No;No;No";
      }
      echo $texto."<br>";
      }


      }

      public function actionProceso6()
      {

      $inscripciones=Inscripcion::find()->all();
      foreach($inscripciones as $inscripcion){
      $texto="";
      $institucion=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$inscripcion->codigo_modular])->one();
      if($institucion){
      $dni=Estudiante::find()->where('dni=:dni',[':dni'=>$inscripcion->dni])->one();
      $email=Estudiante::find()->where('email=:email',[':email'=>$inscripcion->email])->one();
      $Cantidadestudiante=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->count();
      $duplicados=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->all();


      if($Cantidadestudiante>=2)
      {
      $txt="";
      foreach($duplicados as $duplicado)
      {
      $txt=$txt."    Si    Datos dni:".$duplicado->dni.", correo:".$duplicado->email."xxx";
      }
      $texto=$texto.$txt.";;;";
      }
      elseif($Cantidadestudiante==1 && $dni)
      {
      $institucion=Institucion::find()->where('id=:id',[':id'=>$dni->institucion_id])->one();
      $texto=$texto."Si;".$institucion->codigo_modular.";".$institucion->denominacion.";".$dni->nombres." ".$dni->apellido_paterno." ".$dni->apellido_materno.";".$dni->dni.";".$dni->email;
      }
      elseif($Cantidadestudiante==1 && $email)
      {
      $institucion=Institucion::find()->where('id=:id',[':id'=>$email->institucion_id])->one();
      $texto=$texto."Si;".$institucion->codigo_modular.";".$institucion->denominacion.";".$email->nombres." ".$email->apellido_paterno." ".$email->apellido_materno.";".$email->dni.";".$email->email;
      }
      else
      {
      $texto=$texto."Si;No";
      }


      }
      else
      {
      $texto=$texto."No;No;No;No;No";
      }
      echo $texto."<br>";
      }


      }

      public function actionProceso5()
      {

      $inscripciones=Inscripcion::find()->all();
      foreach($inscripciones as $inscripcion){
      $texto="";
      $institucion=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$inscripcion->codigo_modular])->one();
      if($institucion){


      $texto=$texto."Si";
      }
      else
      {
      $texto=$texto."No";
      }
      echo $texto."<br>";
      }


      }
     */

    public function actionProceso1() {
        /* sirver para registrar en estudiante y usuario */
        $inscripciones = Inscripcion::find()->all();
        $contador = 1;
        foreach ($inscripciones as $inscripcion) {
            $institucion = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $inscripcion->codigo_modular])->one();
            if ($institucion) {
                $estudiante = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                $estudianteCount = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->count();

                if ($estudianteCount <= 1) {
                    if ($estudiante) {
                        /*
                          $estudiante->email=$inscripcion->email;
                          $estudiante->dni=$inscripcion->dni;
                          $estudiante->apellido_paterno=$inscripcion->paterno;
                          $estudiante->apellido_materno=$inscripcion->materno;
                          $estudiante->nombres=$inscripcion->nombres;
                          $estudiante->celular=$inscripcion->celular;
                          $estudiante->fecha_nac=$inscripcion->fec_nac;
                          $estudiante->grado=$inscripcion->grado;
                          $estudiante->update();
                          $usuario=Usuario::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
                          $usuario->username=$inscripcion->email;
                          $usuario->password='$2y$13$T6OEJW0WjS30nlKofw5gTetHkSrhKPAddewnCJR1jkjdljcWw0rvu';
                          $usuario->update(); */
                        echo "se ha actualizado el email,dni y contraseña en base al excel :" . $estudiante->dni . "<br>";
                    } else {
                        $estudiante = new Estudiante();
                        $estudiante->institucion_id = $institucion->id;
                        $estudiante->dni = $inscripcion->dni;
                        $estudiante->email = $inscripcion->email;
                        $estudiante->apellido_paterno = $inscripcion->paterno;
                        $estudiante->apellido_materno = $inscripcion->materno;
                        $estudiante->nombres = $inscripcion->nombres;
                        $estudiante->celular = $inscripcion->celular;
                        $estudiante->fecha_nac = $inscripcion->fec_nac;
                        $estudiante->grado = $inscripcion->grado;
                        $estudiante->save();

                        $usuario = new Usuario;
                        $usuario->username = $inscripcion->email;
                        $usuario->password = '$2y$13$T6OEJW0WjS30nlKofw5gTetHkSrhKPAddewnCJR1jkjdljcWw0rvu';
                        $usuario->status = 1;
                        $usuario->avatar = "no_disponible.jpg";
                        $usuario->estudiante_id = $estudiante->id;
                        $usuario->fecha_registro = date("Y-m-d H:i:s");
                        $usuario->save();
                        echo "Se ha creado al estudiante: " . $estudiante->dni . "<br>";
                    }
                    /*
                      if($inscripcion->rol==1)
                      {
                      $coordinador=Integrante::find()->where('estudiante_id=:estudiante_id and rol=1',[':estudiante_id'=>$estudiante->id])->one();
                      if($coordinador)
                      {
                      $equipo=Equipo::find()->where('id=:id',[':id'=>$coordinador->equipo_id])->one();
                      }
                      else
                      {
                      $equipo=new Equipo;
                      $equipo->descripcion_equipo=$inscripcion->equipo;
                      $equipo->descripcion=$inscripcion->equipo;
                      $equipo->fecha_registro=date("Y-m-d H:i:s");
                      $equipo->estado=0;
                      $equipo->etapa=0;
                      $equipo->save();
                      $coordinador=new Integrante;
                      $coordinador->estudiante_id=$estudiante->id;
                      $coordinador->equipo_id=$equipo->id;
                      $coordinador->rol=1;
                      $coordinador->estado=1;
                      $coordinador->save();
                      echo "Se ha creado al lider del equipo: ".$inscripcion->equipo." con dni".$inscripcion->dni."<br>";
                      }
                      } */
                } else {
                    echo "El usuario DNI:" . $inscripcion->dni . " presenta doble registro <br>";
                }
            } else {
                echo "El usuario DNI:" . $inscripcion->dni . " su codigo modular se encuentra erroneo <br>";
            }
            echo $contador;
            $contador++;
        }
    }

    public function actionProceso2() {
        /* Para crear lider dentro de integrante y creacion de equipo */
        $contador = 1;
        $equipos = 1;
        $inscripciones = Inscripcion::find()->where('rol=1')->all();
        foreach ($inscripciones as $inscripcion) {
            $institucion = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $inscripcion->codigo_modular])->one();
            if ($institucion) {
                $estudiante = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                $estudianteCount = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->count();

                if ($estudianteCount <= 1 && $inscripcion->rol == 1) {

                    $coordinador = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
                    //var_dump($coordinador);
                    if ($coordinador && $coordinador->rol == 1) {
                        $equipo = Equipo::find()->where('id=:id', [':id' => $coordinador->equipo_id])->one();
                        echo "Ya es lider del equipo " . $equipo->descripcion_equipo . " " . $estudiante->dni . "<br>";
                    } elseif ($coordinador && $coordinador->rol == 2) {
                        $equipo = Equipo::find()->where('id=:id', [':id' => $coordinador->equipo_id])->one();
                        echo "Es integrante del equipo " . $equipo->descripcion_equipo . " " . $estudiante->dni . "<br>";
                    } else {
                        $equipo = new Equipo;
                        $equipo->descripcion_equipo = $inscripcion->equipo;
                        $equipo->descripcion = $inscripcion->equipo;
                        $equipo->fecha_registro = date("Y-m-d H:i:s");
                        $equipo->estado = 0;
                        $equipo->etapa = 0;
                        $equipo->save();
                        $coordinador = new Integrante;
                        $coordinador->estudiante_id = $estudiante->id;
                        $coordinador->equipo_id = $equipo->id;
                        $coordinador->rol = 1;
                        $coordinador->estado = 1;
                        $coordinador->save();
                        $invitados = Inscripcion::find()->where('lider_id=:lider_id and rol=2', [':lider_id' => $estudiante->id])->all();
                        foreach ($invitados as $invitado) {
                            $invitacion = new Invitacion;
                            $invitacion->equipo_id = $equipo->id;
                            $invitacion->estudiante_id = $coordinador->estudiante_id;
                            $invitacion->estudiante_invitado_id = $invitado->estudiante_id;
                            $invitacion->estado = 2;
                            $invitacion->fecha_invitacion = date("Y-m-d H:i:s");
                            $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
                            $invitacion->save();

                            $integrante = new Integrante;
                            $integrante->equipo_id = $equipo->id;
                            $integrante->estudiante_id = $invitado->estudiante_id;
                            $integrante->rol = 2;
                            $integrante->estado = 1;
                            $integrante->save();
                        }



                        echo "Se ha creado al lider del equipo: " . $inscripcion->equipo . " con dni" . $inscripcion->dni . "<br>";
                        $equipos++;
                    }
                } else {
                    echo "El usuario DNI:" . $inscripcion->dni . " presenta doble registro <br>";
                }
            } else {
                echo "El usuario DNI:" . $inscripcion->dni . " su codigo modular se encuentra erroneo <br>";
            }
            echo $contador;
            $contador++;
        }
        echo "equipo creados" . $equipos;
    }

    public function actionProceso3() {
        /* Para realizar invitaciones y pertenecer al equipo */
        $contador = 1;
        $inscripciones = Inscripcion::find()->where('rol=1')->all();
        foreach ($inscripciones as $inscripcion) {
            $institucion = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $inscripcion->codigo_modular])->one();
            if ($institucion) {
                $estudiante = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                $estudianteCount = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->count();

                if ($estudianteCount <= 1 && $inscripcion->rol == 1) {
                    $coordinador = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
                    if ($coordinador && $coordinador->rol == 1) {
                        $compañeros = Inscripcion::find()->where('lider_equipo=:lider_equipo', [':lider_equipo' => $coordinador->email])->all();
                        $bandera_invitacion = 0;
                        foreach ($compañeros as $compañero) {
                            $est = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                            $invitaciones_compañero = Invitacion::find()->where('estado in (1,2)  and estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $est->id])->all();

                            $invitacion_lider = Invitacion::find()->where('estado in (1,2) and estudiante_id=:estudiante_id and estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $est->id, ':estudiante_id' => $coordinador->estudiante_id])->one();

                            if ($invitaciones_compañero) {
                                foreach ($invitaciones_compañero as $invitacion_compañero) {
                                    if ($invitacion_compañero->estado == 1 && $invitacion_compañero->estudiante_id == $coordinador->estudiante_id) {
                                        //Tiene invitación pendiente de tu equipo
                                        echo "Ya tiene invitación de tu equipo" . "<br>";
                                        $invi = Invitacion::find()->where('estado in (1,2) and estudiante_id=:estudiante_id and estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $est->id, ':estudiante_id' => $coordinador->estudiante_id])->one();
                                        $invi->estado = 2;
                                        $invi->update();
                                        Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id and id not in (' . $invi->id . ')', [':estudiante_invitado_id' => $est->id]);
                                        $integrante = new Integrante;
                                        $integrante->equipo_id = $coordinador->equipo_id;
                                        $integrante->estudiante_id = $coordinador->estudiante_id;
                                        $integrante->rol = 2;
                                        $integrante->estado = 1;
                                        $integrante->save();
                                    } elseif ($invitacion_compañero->estado == 1 && $invitacion_compañero->estudiante_id != $coordinador->estudiante_id) {
                                        //Tiene invitaciones de otros equipos
                                        $bandera_invitacion = 0;
                                    } elseif ($invitacion_compañero->estado == 2 && $invitacion_compañero->estudiante_id == $coordinador->estudiante_id) {
                                        //Acepto invitación de tu equipo
                                    } elseif ($invitacion_compañero->estado == 2 && $invitacion_compañero->estudiante_id != $coordinador->estudiante_id) {
                                        //Acepto invitación de otro equipo
                                    }
                                }
                            } else {
                                $invitacion = new Invitacion;
                                $invitacion->equipo_id = $equipo->id;
                                $invitacion->estudiante_id = $coordinador->estudiante_id;
                                $invitacion->estudiante_invitado_id = $est->id;
                                $invitacion->estado = 2;
                                $invitacion->fecha_invitacion = date("Y-m-d H:i:s");
                                $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
                                $invitacion->save();
                                $integrante = new Integrante;
                                $integrante->equipo_id = $coordinador->equipo_id;
                                $integrante->estudiante_id = $est->id;
                                $integrante->rol = 2;
                                $integrante->estado = 1;
                                $integrante->save();
                                echo "registro de invitacion e integrante" . "<br>";
                            }
                        }
                    } elseif ($coordinador && $coordinador->rol == 2) {
                        $equipo = Equipo::find()->where('id=:id', [':id' => $coordinador->equipo_id])->one();
                        echo "Es integrante del equipo " . $equipo->descripcion_equipo;
                    } else {
                        echo "Lo sentimos sigue intentando";
                    }
                } else {
                    echo "El usuario DNI:" . $inscripcion->dni . " presenta doble registro <br>";
                }
            } else {
                echo "El usuario DNI:" . $inscripcion->dni . " su codigo modular se encuentra erroneo <br>";
            }
            echo $contador;
            $contador++;
        }
    }

    public function actionProceso4() {
        $inscripciones = Inscripcion::find()->where('rol=1')->all();
        foreach ($inscripciones as $inscripcion) {
            $institucion = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $inscripcion->codigo_modular])->one();
            if ($institucion) {
                $estudiante = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                $estudiantecount = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->count();
                if ($estudiantecount <= 1) {
                    $coordinador = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();
                    $equipo = Equipo::find()->where('id=:id', [':id' => $coordinador->equipo_id])->one();
                    $estudiantes_por_invitarlos = Inscripcion::find()->where('equipo!="" and equipo is not null and rol=2 and lider_equipo=:lider_equipo', [':lider_equipo' => $inscripcion->email])->all();
                    foreach ($estudiantes_por_invitarlos as $estudiante_por_invitar) {
                        $institucionx = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $estudiante_por_invitar->codigo_modular])->one();
                        if ($institucionx) {
                            $estudianteainvitar = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $estudiante_por_invitar->dni, ':email' => $estudiante_por_invitar->email])->one();
                            $invitaciones = Invitacion::find()
                                    ->where('estado=1 and estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $estudianteainvitar->id])
                                    ->all();

                            $invitacionesexiste = Invitacion::find()
                                    ->where('estado=2 and estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $estudianteainvitar->id])
                                    ->one();


                            $integrantesexiste = Integrante::find()
                                    ->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudianteainvitar->id])
                                    ->one();
                            //var_dump($invitacionesexiste->estado);
                            if (!$integrantesexiste) {
                                if ($invitaciones) {
                                    foreach ($invitaciones as $invitacion) {
                                        $invi = Invitacion::findOne($invitacion->id);
                                        if ($invitacion->estado == 1 && $invitacion->estudiante_id == $estudiante->id) {
                                            $invi->estado = 2;
                                            $invi->update();
                                            $integrante = new Integrante;
                                            $integrante->equipo_id = $equipo->id;
                                            $integrante->estudiante_id = $estudianteainvitar->id;
                                            $integrante->rol = 2;
                                            $integrante->estado = 1;
                                            $integrante->save();
                                            echo "se ha actualizado la invitacion a estado=2 y ya perteneces al equipo" . $estudiante_por_invitar->dni . "<br>";
                                        } else {
                                            $invi->estado = 0;
                                            $invi->update();
                                            echo "Tenia invitación de otro equipo y se le cancelo la invitación" . $estudiante_por_invitar->dni . "<br>";
                                        }
                                    }
                                } elseif ($invitacionesexiste) {
                                    $integrante = new Integrante;
                                    $integrante->equipo_id = $equipo->id;
                                    $integrante->estudiante_id = $estudianteainvitar->id;
                                    $integrante->rol = 2;
                                    $integrante->estado = 1;
                                    $integrante->save();
                                } else {
                                    $invitacion = new Invitacion;
                                    $invitacion->equipo_id = $equipo->id;
                                    $invitacion->estudiante_id = $estudiante->id;
                                    $invitacion->estudiante_invitado_id = $estudianteainvitar->id;
                                    $invitacion->estado = 2;
                                    $invitacion->fecha_invitacion = date("Y-m-d H:i:s");
                                    $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
                                    $invitacion->save();
                                    $integrante = new Integrante;
                                    $integrante->equipo_id = $equipo->id;
                                    $integrante->estudiante_id = $estudianteainvitar->id;
                                    $integrante->rol = 2;
                                    $integrante->estado = 1;
                                    $integrante->save();
                                    "Se le ha invitado y pertenece al equipo" . $estudiante_por_invitar->dni . "<br>";
                                }
                            } else {
                                echo "ya pertenece a un equipo" . $estudiante_por_invitar->dni . "<br>";
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionProceso5() {
        $inscripciones = Inscripcion::find()->where('equipo!="" and equipo is not null and rol=1')->all();
        foreach ($inscripciones as $inscripcion) {
            Inscripcion::updateAll(['lider_equipo' => $inscripcion->email, 'codigo_modular' => str_pad($inscripcion->codigo_modular, 7, "0", STR_PAD_LEFT)], 'equipo!="" and equipo is not null and rol=2 and equipo=:equipo', [':equipo' => $inscripcion->equipo]);
        }
    }

    public function actionProceso10() {
        /* Para realizar invitaciones y pertenecer al equipo */
        $contador = 1;
        $inscripciones = Inscripcion::find()->all();
        foreach ($inscripciones as $inscripcion) {
            $institucion = Institucion::find()->where('codigo_modular=:codigo_modular', [':codigo_modular' => $inscripcion->codigo_modular])->one();
            if ($institucion) {
                $estudiante = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->one();
                $estudianteCount = Estudiante::find()->where('dni=:dni or email=:email', [':dni' => $inscripcion->dni, ':email' => $inscripcion->email])->count();

                if ($estudianteCount <= 1) {
                    $coordinador = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $estudiante->id])->one();

                    if ($coordinador && $coordinador->rol == 1) {
                        echo "Eres lider <br>";
                    } elseif ($coordinador && $coordinador->rol == 2) {
                        echo "Eres integrante <br>";
                    } else {
                        $invitaciones = Invitacion::find()->where('estudiante_invitado_id=:estudiante_invitado_id and estado=1', [':estudiante_invitado_id' => $estudiante->id])->all();


                        if ($invitaciones) {
                            $equipo = Equipo::find()->where('descripcion_equipo=:descripcion_equipo', [':descripcion_equipo' => $inscripcion->equipo])->one();
                            if ($equipo) {
                                $lider = Integrante::find()->where('equipo_id=:equipo_id and rol=1', [':equipo_id' => $equipo->id])->one();
                                $lider_estudiante = Estudiante::find()->where('id=:id', [':id' => $lider->estudiante_id])->one();
                                if ($lider_estudiante->institucion_id == $estudiante->institucion_id) {
                                    $invitacion_lider = Invitacion::find()->where('estudiante_invitado_id=:estudiante_invitado_id and estudiante_id=:estudiante_id and estado=1', [':estudiante_invitado_id' => $estudiante->id, ':estudiante_id' => $lider_estudiante->id])
                                            ->one();
                                    if ($invitacion_lider) {
                                        $invitacion_lider->estado = 2;
                                        $invitacion_lider->update();
                                        $integrante = new Integrante;
                                        $integrante->equipo_id = $equipo->id;
                                        $integrante->estudiante_id = $estudiante->id;
                                        $integrante->rol = 2;
                                        $integrante->estado = 1;
                                        $integrante->save();
                                        Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id and id not in (' . $invitacion_lider->id . ')', [':estudiante_invitado_id' => $estudiante->id]);
                                        echo "aceptar invitacion e ingresar a integrantes y actualizar los demas registros de mi estudiante_id a 0 dni" . $estudiante->dni . " <br>";
                                    } else {
                                        $invitacion = new Invitacion;
                                        $invitacion->equipo_id = $equipo->id;
                                        $invitacion->estudiante_id = $lider->id;
                                        $invitacion->estudiante_invitado_id = $estudiante->id;
                                        $invitacion->estado = 2;
                                        $invitacion->fecha_invitacion = date("Y-m-d H:i:s");
                                        $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
                                        $invitacion->save();
                                        $integrante = new Integrante;
                                        $integrante->equipo_id = $equipo->id;
                                        $integrante->estudiante_id = $estudiante->id;
                                        $integrante->rol = 2;
                                        $integrante->estado = 1;
                                        $integrante->save();
                                        Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id and id not in (' . $invitacion->id . ')', [':estudiante_invitado_id' => $estudiante->id]);
                                        echo "se registro una invitacion aceptada y formar parte de integrantes y los demas registros a 0 dni" . $estudiante->dni . "<br>";
                                    }
                                } else {
                                    echo "no pertenecen al mismo colegio <br>" . "dni estudiante" . $estudiante->dni . " dni lider " . $lider_estudiante->dni . "<br>";
                                }
                            } else {
                                echo "tu equipo no existe o no se encontro coincidencia <br>";
                            }
                        } else {
                            $equipo = Equipo::find()->where('descripcion_equipo=:descripcion_equipo', [':descripcion_equipo' => $inscripcion->equipo])->one();
                            if ($equipo) {
                                $lider = Integrante::find()->where('equipo_id=:equipo_id and rol=1', [':equipo_id' => $equipo->id])->one();
                                $lider_estudiante = Estudiante::find()->where('id=:id', [':id' => $lider->estudiante_id])->one();
                                if ($lider_estudiante->institucion_id == $estudiante->institucion_id) {
                                    $invitacion = new Invitacion;
                                    $invitacion->equipo_id = $equipo->id;
                                    $invitacion->estudiante_id = $lider->id;
                                    $invitacion->estudiante_invitado_id = $estudiante->id;
                                    $invitacion->estado = 2;
                                    $invitacion->fecha_invitacion = date("Y-m-d H:i:s");
                                    $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
                                    $invitacion->save();
                                    $integrante = new Integrante;
                                    $integrante->equipo_id = $equipo->id;
                                    $integrante->estudiante_id = $estudiante->id;
                                    $integrante->rol = 2;
                                    $integrante->estado = 1;
                                    $integrante->save();
                                    echo "se registro invitacion,integrante dni " . $estudiante->dni . "<br>";
                                } else {
                                    echo "no pertenecen al mismo colegio <br>" . "dni estudiante" . $estudiante->dni . " dni lider " . $lider_estudiante->dni . "<br>";
                                }
                            } else {
                                echo "No se encontro coincidencia con los equipos registrados dni " . $estudiante->dni . " <br>";
                            }
                        }
                    }
                } else {
                    echo "El usuario DNI:" . $inscripcion->dni . " presenta doble registro <br>";
                }
            } else {
                echo "El usuario DNI:" . $inscripcion->dni . " su codigo modular se encuentra erroneo <br>";
            }
            echo $contador . "<br>";
            $contador++;
        }
    }

    public function actionDejarEquipo() {
        //$id=$_POST["id"];
        $arrays = [2052, 4447, 4611, 5706, 894];
        $inscripciones = Inscripcion::find()
                ->select('lider_id')
                ->all();

        foreach ($arrays as $array => $key) {
            $id = $key;
            $lider = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $id])->one();
            if ($lider) {
                //Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$lider->equipo_id])->one()->deleteAll();
                Invitacion::updateAll(['estado' => 0], 'equipo_id=:equipo_id', [':equipo_id' => $lider->equipo_id]);

                Integrante::deleteAll('equipo_id=:equipo_id', [':equipo_id' => $lider->equipo_id]);

                Equipo::find()->where('id=:id', [':id' => $lider->equipo_id])->one()->delete();
            } else {
                Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $id])->one()->delete();
                Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $id]);
            }
        }
    }

    /*
      public function actionProyectos()
      {
      $etapa=Etapa::find()->where('estado=1')->one();
      $proyectosx=ProyectoCopia::find()->where('etapa=1 and id not in (7)')->all();

      $proyecto=new Proyecto;
      $proyecto->load(Yii::$app->request->post());
      foreach($proyectosx as $proyectox)
      {
      $proyectoexiste=ProyectoCopia::find()->where('id=:id and etapa=2',[':id'=>$proyectox->id])->one();
      if(!$proyectoexiste)
      {
      $proyectocopia =    'insert into proyecto_copia (id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,etapa)
      select id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,2 from proyecto
      where id='.$proyectox->id.'  ';
      \Yii::$app->db->createCommand($proyectocopia)->execute();

      $objetivosespecificoscopia =    'insert into objetivo_especifico_copia (id,proyecto_id,descripcion,etapa)
      select id,proyecto_id,descripcion,2 from objetivo_especifico
      where proyecto_id='.$proyectox->id.'  ';
      \Yii::$app->db->createCommand($objetivosespecificoscopia)->execute();

      $actividadcopia =    'insert into actividad_copia (id,objetivo_especifico_id,descripcion,resultado_esperado,estado,etapa)
      select actividad.id,actividad.objetivo_especifico_id,actividad.descripcion,actividad.resultado_esperado,actividad.estado,2 from actividad
      inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
      where objetivo_especifico.proyecto_id='.$proyectox->id.' and actividad.estado=1 ';
      \Yii::$app->db->createCommand($actividadcopia)->execute();


      $planpresupuestalcopia =    'insert into plan_presupuestal_copia (id,actividad_id,recurso,como_conseguirlo,precio_unitario,cantidad,subtotal,estado,etapa,dirigido,recurso_descripcion,unidad)
      select plan_presupuestal.id,plan_presupuestal.actividad_id,plan_presupuestal.recurso,
      plan_presupuestal.como_conseguirlo,plan_presupuestal.precio_unitario,plan_presupuestal.cantidad,
      plan_presupuestal.subtotal,plan_presupuestal.estado,2,plan_presupuestal.dirigido,plan_presupuestal.recurso_descripcion,plan_presupuestal.unidad
      from plan_presupuestal
      inner join actividad on plan_presupuestal.actividad_id=actividad.id
      inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
      where objetivo_especifico.proyecto_id='.$proyectox->id.' and plan_presupuestal.estado=1  ';
      \Yii::$app->db->createCommand($planpresupuestalcopia)->execute();

      $cronogramacopia =    'insert into cronograma_copia (id,actividad_id,fecha_inicio,fecha_fin,duracion,responsable_id,estado,etapa,tarea)
      select cronograma.id,cronograma.actividad_id,cronograma.fecha_inicio,cronograma.fecha_fin,
      cronograma.duracion,cronograma.responsable_id,cronograma.estado,2,cronograma.tarea
      from cronograma
      inner join actividad on cronograma.actividad_id=actividad.id
      inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
      where objetivo_especifico.proyecto_id='.$proyectox->id.' and cronograma.estado=1 ';
      \Yii::$app->db->createCommand($cronogramacopia)->execute();

      $videocopia =    'insert into video_copia (id,proyecto_id,ruta,etapa)
      select id,proyecto_id,ruta,2 from video
      where proyecto_id='.$proyectox->id.' and etapa=0';
      \Yii::$app->db->createCommand($videocopia)->execute();


      $usuario=Usuario::findOne($proyectox->user_id);
      $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
      $video=Video::find()->where('proyecto_id=:proyecto_id and etapa=:etapa',
      [':proyecto_id'=>$proyectox->id,':etapa'=>0])->one();
      if($video)
      {
      $video->etapa=2;
      $video->update();
      }

      $proyectoetapa=Proyecto::findOne($proyectox->id);
      $equipo=Equipo::findOne($proyectoetapa->equipo_id);
      $equipo->etapa=$etapa->etapa;
      $equipo->update();

      echo 1;
      }
      }
      } */
}
