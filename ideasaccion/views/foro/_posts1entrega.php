<?php 

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
\Yii::$app->language = 'es-ES';



$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($pageSize * $_GET['page']) - $pageSize;
?>

<section class="posts">
    <div class="post-title">
        <!--<h3><?= Yii::t('app', '{postCount} comentarios', ['postCount' => $postCount]) ?></h3>-->
    </div>
    <div id="post-list">
        <?php foreach($posts as $post):
            $floor_number=$floor++; //楼层数减少
            ?>
            <div class="row post-item">
                <div class="col-sm-12 col-md-12">
                    <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                    <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">
                        <?= HtmlPurifier::process($post['contenido']) ?>
                        <div class="post-meta">
                            <div class="col-sm-12 col-md-12"></div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12">
                                <div class="pull-right">
                                    <div class="col-sm-12 col-md-12">
                                        <?= $post['nombres'] ?> <?= zdateRelative($post['creado_at']) ?>
                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php }else{ ?>
                    <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">
                        <?= HtmlPurifier::process($post['contenido']) ?>
                        <div class="post-meta">
                            <div class="col-sm-12 col-md-12"></div>
                            <div class="col-sm-12 col-md-12">
                                <div class="br-wrapper br-theme-fontawesome-stars pull-right">
                                    <select class="disabled" disabled> <!-- now hidden -->
                                      <option value></option>
                                      <option value="1" <?= ($post['valoracion']==1)?'selected':'' ?> >1</option>
                                      <option value="2" <?= ($post['valoracion']==2)?'selected':'' ?> >2</option>
                                      <option value="3" <?= ($post['valoracion']==3)?'selected':'' ?> >3</option>
                                      <option value="4" <?= ($post['valoracion']==4)?'selected':'' ?> >4</option>
                                      <option value="5" <?= ($post['valoracion']==5)?'selected':'' ?> >5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12">
                                <div class="pull-right">
                                    Comentario de <?= $post['nombres']." ".$post['apellido_paterno'] ?> <?= zdateRelative($post['creado_at']) ?>
                            
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php endforeach; ?>
        <div class="row post-item" align="center">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'lastPageLabel' => true,
                'firstPageLabel' => true
            ]);?>    
        </div>
        
        
    </div>
</section>

<script>
    $('.disabled').barrating({
        theme: 'fontawesome-stars',
        hoverState: false,
        readonly: true
      });
</script>

