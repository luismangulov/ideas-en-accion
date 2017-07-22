<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAssetInterno;

AppAssetInterno::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../js/bootbox.min.js"></script>
<script src="../js/bootstrap.min.js"></script>	
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
    <div class="row">
	<div class="btn-group btn-group-justified">
            <div class="btn-group">
		<?= Html::a('<button type="button" class="btn btn-nav">
			<span class="glyphicon glyphicon-folder-close"></span>
    			<p>¿Qué es?</p>
		    </button>',['site/que-es'],[]);?>
            </div>
            <div class="btn-group">
		<?= Html::a('<button type="button" class="btn btn-nav">
			<span class="glyphicon glyphicon-calendar"></span>
			    <p>Etapas</p>
		    </button>',['site/etapas'],[]);?>
            </div>
            <div class="btn-group">
		<?= Html::a('<button type="button" class="btn btn-nav">
                    <span class="glyphicon glyphicon-globe"></span>
    			<p>Bases</p>
                </button>',['site/bases'],[]);?>
		    
                
            </div>
            <div class="btn-group">
		<?= Html::a('<button type="button" class="btn btn-nav">
			<span class="glyphicon glyphicon-leaf"></span>
			    <p>Asuntos Públicos</p>
		    </button>',['site/asuntos-publicos'],[]);?>
            </div>
            <div class="btn-group">
		<?= Html::a('<button type="button" class="btn btn-nav">
			<span class="glyphicon glyphicon-time"></span>
			    <p>Apuntate</p>
		    </button>',['site/login'],[]);?>
            </div>
        </div>
    </div>
</div>
    <div class="container">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
