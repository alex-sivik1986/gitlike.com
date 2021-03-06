<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Reposit;
use yii\widgets\Pjax;
?>
<div class="cabinet-default-index">
    <h1>List repositories</h1>
<!-- Search form -->
<form method="get" action="/cabinet/default/search" class="form-inline d-flex justify-content-center md-form form-sm mt-0">
  <i class="fas fa-search" aria-hidden="true"></i>
  <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search" name="reposit"
    aria-label="Search">
</form>
<?php Pjax::begin(['id' => 'my_pjax',  'enablePushState'=>TRUE]); ?>
<?= GridView::widget([
        'dataProvider' => $repositories,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'html_url',
			[
				'label' => 'You liked?',
				'format' => 'raw',
				'value' => function($data){
			
					$like = '<label pjax-container = "my_pjax" style="cursor:pointer" data-action="like"  data-name='.$data["name"].' data-id='.$data["id"].' class="like btn x-radio-label" for="helpfulness-yes-xl">
      <svg version="1.1" width="24" height="24" viewBox="0 0 24 24" class="octicon octicon-thumbsup" aria-hidden="true"><path fill-rule="evenodd" d="M12.596 2.043c-1.301-.092-2.303.986-2.303 2.206v1.053c0 2.666-1.813 3.785-2.774 4.2a1.866 1.866 0 01-.523.131A1.75 1.75 0 005.25 8h-1.5A1.75 1.75 0 002 9.75v10.5c0 .967.784 1.75 1.75 1.75h1.5a1.75 1.75 0 001.742-1.58c.838.06 1.667.296 2.69.586l.602.17c1.464.406 3.213.824 5.544.824 2.188 0 3.693-.204 4.583-1.372.422-.554.65-1.255.816-2.05.148-.708.262-1.57.396-2.58l.051-.39c.319-2.386.328-4.18-.223-5.394-.293-.644-.743-1.125-1.355-1.431-.59-.296-1.284-.404-2.036-.404h-2.05l.056-.429c.025-.18.05-.372.076-.572.06-.483.117-1.006.117-1.438 0-1.245-.222-2.253-.92-2.941-.684-.675-1.668-.88-2.743-.956zM7 18.918c1.059.064 2.079.355 3.118.652l.568.16c1.406.39 3.006.77 5.142.77 2.277 0 3.004-.274 3.39-.781.216-.283.388-.718.54-1.448.136-.65.242-1.45.379-2.477l.05-.384c.32-2.4.253-3.795-.102-4.575-.16-.352-.375-.568-.66-.711-.305-.153-.74-.245-1.365-.245h-2.37c-.681 0-1.293-.57-1.211-1.328.026-.243.065-.537.105-.834l.07-.527c.06-.482.105-.921.105-1.25 0-1.125-.213-1.617-.473-1.873-.275-.27-.774-.455-1.795-.528-.351-.024-.698.274-.698.71v1.053c0 3.55-2.488 5.063-3.68 5.577-.372.16-.754.232-1.113.26v7.78zM3.75 20.5a.25.25 0 01-.25-.25V9.75a.25.25 0 01.25-.25h1.5a.25.25 0 01.25.25v10.5a.25.25 0 01-.25.25h-1.5z"></path></svg>
				</label>'; 
				return (($data['like'] == 1)?'liked':$like);
				}
			],
			[
				'label' => 'or Not?',
				'format' => 'raw',
				'value' => function($data){ 
					
					$dislike = '<label pjax-container = "my_pjax" data-action="dislike"  style="cursor:pointer" data-name='.$data["name"].' data-id='.$data["id"].' class="dislike btn x-radio-label" for="helpfulness-no-xl">
      <svg version="1.1" width="24" height="24" viewBox="0 0 24 24" class="octicon octicon-thumbsdown" aria-hidden="true"><path fill-rule="evenodd" d="M12.596 21.957c-1.301.092-2.303-.986-2.303-2.206v-1.053c0-2.666-1.813-3.785-2.774-4.2a1.864 1.864 0 00-.523-.13A1.75 1.75 0 015.25 16h-1.5A1.75 1.75 0 012 14.25V3.75C2 2.784 2.784 2 3.75 2h1.5a1.75 1.75 0 011.742 1.58c.838-.06 1.667-.296 2.69-.586l.602-.17C11.748 2.419 13.497 2 15.828 2c2.188 0 3.693.204 4.583 1.372.422.554.65 1.255.816 2.05.148.708.262 1.57.396 2.58l.051.39c.319 2.386.328 4.18-.223 5.394-.293.644-.743 1.125-1.355 1.431-.59.296-1.284.404-2.036.404h-2.05l.056.429c.025.18.05.372.076.572.06.483.117 1.006.117 1.438 0 1.245-.222 2.253-.92 2.942-.684.674-1.668.879-2.743.955zM7 5.082c1.059-.064 2.079-.355 3.118-.651.188-.054.377-.108.568-.16 1.406-.392 3.006-.771 5.142-.771 2.277 0 3.004.274 3.39.781.216.283.388.718.54 1.448.136.65.242 1.45.379 2.477l.05.385c.32 2.398.253 3.794-.102 4.574-.16.352-.375.569-.66.711-.305.153-.74.245-1.365.245h-2.37c-.681 0-1.293.57-1.211 1.328.026.244.065.537.105.834l.07.527c.06.482.105.922.105 1.25 0 1.125-.213 1.617-.473 1.873-.275.27-.774.456-1.795.528-.351.024-.698-.274-.698-.71v-1.053c0-3.55-2.488-5.063-3.68-5.577A3.485 3.485 0 007 12.861V5.08zM3.75 3.5a.25.25 0 00-.25.25v10.5c0 .138.112.25.25.25h1.5a.25.25 0 00.25-.25V3.75a.25.25 0 00-.25-.25h-1.5z"></path></svg>
					</label>'; 
					return (($data['dislike'] == 1)?'disliked':$dislike);
				}
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Просмотр', 
				'template' => '{view}',
				'buttons' => [
				'view' => function ($url, $model) { 
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'lead-view')]);
					},
				],
				'urlCreator' => function ($action, $model, $key, $index) { 
				if ($action === 'view') {
					$url ='/cabinet/default/reposit?name='.$model['name'].'&id='.$model['id'];
					return $url;
				}
          }

        ],
		 
    ]
	]); ?>

<?php Pjax::end(); ?>

</div>
<?php
/*$this->registerJs(
   '$("document").ready(function(){ 
		$("#likes").on("pjax:end", function() {
			$.pjax.reload({container:"#likes"});  //Reload GridView
		});
    });'
);*/
?>
<?php
$url = Url::to(['default/liked']);
$js = <<< JS

		$(document).on("click", '.like, .dislike', function(){

			var getkey = $(this).data('id');
			var getwork = $(this).data('action');
			var pjaxContainer = $(this).attr('pjax-container');
			var getname = $(this).data('name');
			$.ajax({
				url: '$url',
				type: 'POST',
				data:{id:getkey,act:getwork,name:getname},
				success: function(data){
	$.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 1000});
						//$('.cabinet-default-index').html(data);
					},
					error: function(jqXHR, errMsg) {
						 alert('Error!');
					}
			})


});
JS;

$this->registerJs($js);
?>