<?php

class m130924_105013_settings extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('settings',
			array(
		         'id' => 'pk',
			     'fkey' => 'string',
			     'value' => 'text'
            )
		);
		$this->createIndex('settings_keys', 'settings', 'fkey', true);
	}

	public function safeDown()
	{
		$this->dropIndex('settings_keys', 'settings');
		$this->dropTable('settings');
	}
}