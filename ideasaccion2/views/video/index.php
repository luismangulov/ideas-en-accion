<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\web\JsExpression;
/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */

?>

<h1>Video</h1>
<?php if($integrante->rol==1){?>
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
        <input type="file" id="video-archivo" name="Video[archivo]" class="" accept="video/mp4"><br>
        <input type="submit" id="btnvideo" value="Cargar video">
    <?php ActiveForm::end(); ?>

<div class="progress">
    <div class="bar"></div >
    <div class="percent">0%</div >
</div>
<?php }?>
<video width="320" height="240" controls>
    <source src="<?= Yii::getAlias('@video').$video->ruta ?>" type="video/mp4">  
</video>
<br>



<script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.7/jquery.js"></script>
<script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/jquery.form.js"></script>
<script nonce="<?= getnonceideas() ?>" >
(function() {
    
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
   /* $("#btnvideo").click(function(){
        /*var error='';
        
        console.log($('#video-archivo').val());
        if ($('#video-archivo').val()=='') {
            $.notify({
                message: 'Agregue un video' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }*/
      
        
        $('#w0').ajaxForm({
            beforeSend: function() {
                
                
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
            }
        }); 
       
        //return true;
    //});
})();       
</script>