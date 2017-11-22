<?php
namespace app\widgets\video;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use Madcoda\Youtube;
use app\models\Video;
class VideoWidget extends Widget
{
    public $integrante;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $video=new Video;
        if ($video->load(\Yii::$app->request->post())) {
            foreach($_FILES as $file) {
                $n = $file['name'];
                $s = $file['size'];
                if (is_array($n)) {
                    $c = count($n);
                    for ($i=0; $i < $c; $i++) {
                        echo "<br>uploaded: " . $n[$i] . " (" . $s[$i] . " bytes)";
                    }
                }
                else {
                    echo "<br>uploaded: $n ($s bytes)";
                }
            }
            
            return \Yii::$app->getResponse()->refresh();
        }
        
        return $this->render('video');
    }
}