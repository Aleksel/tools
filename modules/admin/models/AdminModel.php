<?php
/**
 * User: Forgon
 * Date: 10.07.2013 от Рождества Христова
 */

abstract class AdminModel extends CActiveRecord{

	/**
	 * @param $db CDbConnection
	 * @param $class
	 * @param $conf
	 */
	protected static function init_db_table($db, $class, $conf)
	{
		$schem = $db->getSchema();
		$table = $schem->getTable($conf['name']);

		if ($table === null) {
			// Таблицы не существует - создадим ее и пропишем базового администратора
			$columns = array();
			foreach ($conf['columns'] as $cname => $cconf) {
				$columns[$cname] = $cconf['string_type'];
			}

			$command = new CDbCommand(
				$db,
				$schem->createTable($conf['name'], $columns)
			);
			$command->execute();
			unset($columns, $cname, $cconf);

			if ($conf['base_data']) {
				foreach ($conf['base_data'] as $mdata) {
					$model             = new $class('create');
					if (isset($mdata['id'])) {
						$model->primaryKey = $mdata['id'];
						unset($mdata['id']);
					}
					$model->attributes = $mdata;
					if (!$model->save()) {
						Yii::log(CVarDumper::dumpAsString($model->errors,3), CLogger::LEVEL_ERROR, 'admin');
					};
				}
			}
		} else {
			foreach ($conf['columns'] as $cname => $cconf) {
				$col = $table->getColumn($cname);
				if ($col === null) {
					$command = new CDbCommand(
						$db,
						$schem->addColumn($conf['name'], $cname, $cconf['string_type'])
					);
					$command->execute();
				} else {
					$update = false;
					foreach ($cconf['check'] as $par => $val) {
						if ($col->$par !== $val) {
							$update = true;
							break;
						}
					}
					if ($update) {
						$command = new CDbCommand(
							$db,
							$schem->alterColumn($conf['name'], $cname, $cconf['string_type'])
						);
						$command->execute();
					}
				}
			}
		}
	}

	/**
	 * Вернуть имя класса
	 * @throws Exception
	 * @return string
	 */
	public static function getClassName() {
		throw new Exception('Переопределите этот метод на return __CLASS__;');
	}

}