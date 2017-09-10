<?php

use yii\db\Migration;
//use yii\db\Schema;

/**
 * Handles the creation of table `randomnumber`.
 */
class m170910_081218_create_randomnumber_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=101';
		}

        $this->createTable('{{%random_number}}', [
            'id' => $this->primaryKey(), // For mysql eq.: int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT
			'number' => $this->integer()->notNull()->comment('Рандомное число'),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

		//$this->createIndex('idx-random_number-number', '{{%random_number}}', 'number');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%random_number}}');
    }
}
