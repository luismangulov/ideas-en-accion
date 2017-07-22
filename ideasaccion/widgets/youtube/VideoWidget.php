<?php
namespace app\widgets\youtube;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use Madcoda\Youtube;

class VideoWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        
        return $this->render('video');
    }
}