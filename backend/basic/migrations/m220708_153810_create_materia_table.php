<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%materia}}`.
 */
class m220708_153810_create_materia_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%materia}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(128)->notNull(),
            'cant_alumnos' => $this->integer()->defaultValue(5),
            'id_carrera' => $this->integer()->notNull(),
            'id_profesor' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-materia-id_carrera','materia', 'id_carrera');
        $this->createIndex('idx-materia-id_profesor','materia', 'id_profesor');

        $this->addForeignKey('fk-materia-id_carrera', 'materia', 'id_carrera', 'carrera', 'id', 'CASCADE');
        $this->addForeignKey('fk-materia-id_profesor', 'materia', 'id_profesor', 'profesor', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-materia-id_carrera', 'materia');
        $this->dropForeignKey('fk-materia-id_profesor', 'materia');

        $this->dropIndex('idx-materia-id_carrera','materia');
        $this->dropIndex('idx-materia-id_profesor','materia');

        $this->dropTable('{{%materia}}');
    }
}
