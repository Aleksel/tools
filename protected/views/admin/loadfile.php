<?php
/* @var $this LoadFileController */
Yii::app()->getClientScript()->registerCoreScript('jquery');
?>
<h1>Загрузка файла</h1>
<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
<?php echo '<div>'.CHtml::activeFileField($model, 'excel').'</div>'; ?>
<br>
<?php echo '<div>'.CHtml::submitButton('Продолжить').'</div>'; ?>
<?php echo CHtml::endForm(); ?>
<br>
<?php if ('' !== $error) echo "<h2>$error</h2>"; ?>
<?php $files = scandir($path);    //сканируем (получаем массив файлов)
         array_shift($files); // удаляем из массива '.'
         array_shift($files); // удаляем из массива '..'
         for($i=0; $i<sizeof($files); $i++)
		 echo '<div>-файл: <a href="'.'/uploadfiles/'.$files[$i].'" title="открыть/скачать файл или страницу">'.$files[$i].'</a>  <a href="#" class="delete" data-file="'.$files[$i].'">Удалить</a></div>';  //выводим все файлы
?>
<script>

jQuery(function($){
	
	$('.delete').on('click', function(){
		var url = 'loadfile';
		var data =$(this).attr('data-file');

		$.ajax({
			type: "POST",
			async: false,
			url: url,
			//dataType: 'json',
			data: {'f': data},
			success: function(data){
				window.location.reload(true);
				return false;
			}
		});

		return false;
	});

});

</script>