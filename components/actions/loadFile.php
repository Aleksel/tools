<?php

class LoadFile extends CAction
{
	public $layout = '/layouts/default';
	public $ar = array();
	public $ar2 = array();
	public $error='';

	public function run()
	{	
		if (isset($_POST['f']) and !empty($_POST['f']))
		{
			unlink(Yii::app()->basePath.'/../public/uploadfiles/'.$_POST['f']);
			Yii::app()->end();
		}
		
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '10M');
		ini_set('memory_limit', '512M');
		
		if (!is_dir(Yii::app()->basePath.'/../public/excel/'))
			mkdir(Yii::app()->basePath.'/../public/excel/');
		if (!is_dir(Yii::app()->basePath.'/../public/uploadfiles/'))
			mkdir(Yii::app()->basePath.'/../public/uploadfiles/');

		if (!$this->controller->module->adminUser->isGuest){
			$model = new Files;
				if (isset($_POST['Files']) and ('' !==$_FILES['Files']['name']['excel']))
				{
					$model->attributes = $_POST['Files']; // Сохранение данных формы в модели

					// Создание экземпляра класса с информацией о загружаемом файле
					$model->name_file = CUploadedFile::getInstance($model, 'excel');
					$model->id = time();

					//if ($model->save())
					//{
						// Если модель успешно сохранена, то перемещение файла в нужное место и удалением временного файла.
						$model->name_file->saveAs(Yii::app()->basePath.'/../public/excel/'.$model->name_file);

				  $this->initFile(Yii::app()->basePath.'/../public/excel/'.$model->name_file, $model->name_file);
					//}
				}
				$this->getController()->render('/loadfile', array('model'=>$model, 'error' => $this->error, 'path' => Yii::app()->basePath.'/../public/uploadfiles/'));
		}
}
	public function readExelFile($filepath){

		$inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
		$objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
		$objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
		try
		{

			for ($i=1; $i<=$objPHPExcel->getSheet(1)->getHighestRow(); $i++){
				$this->ar2[] = trim($objPHPExcel->getSheet(1)->getCell('A'.$i));
		}
		}
		catch (Exception $e)
		{
			$this->error = "В файле отсутствуем второй лист";
		}
		for ($i=1; $i<=$objPHPExcel->getSheet(0)->getHighestRow(); $i++)
		{
			$this->ar[] = trim($objPHPExcel->getSheet(0)->getCell('A'.$i));
		}

	}

	public function initFile($filepath,$file)
	{
		$xls = new PHPExcel();
		
		//Считываем первый столбец, первых двух листов excel файла
		$this->readExelFile($filepath);

		//Удаляем из первого массива второй массив
		$this->ar = array_diff($this->ar, $this->ar2);

		//Записываем отчищенный массив
		for ($i=1; $i<=count($this->ar); $i++)
		{
			$xls->getSheet(0)->setCellValue('A'.$i, current($this->ar));
			next($this->ar);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($xls, PHPExcel_IOFactory::identify($filepath));

		$path = Yii::app()->basePath.'/../public/uploadfiles/clean_'.$file;

		$objWriter->save($path);

		Header('Location: /uploadfiles/clean_'.$file);
		Yii::app()->request->redirect('loadfile');
	}





	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}