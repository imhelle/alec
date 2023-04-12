<?php

use yii\db\Migration;

/**
 * Class m230222_162322_experiment
 */
class m230222_162322_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taxonomy}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('model organism latin name by UniProt'),
            'uniprot_id' => $this->string(),
        ]);
        
        $this->createTable('{{%strain}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'taxonomy_id' => $this->string()
        ]);
        
        $this->createTable('{{%dwelling_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
        
        $this->createTable('{{%active_substance}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'pubchem_id' => $this->string(),
        ]);
        
        $this->createTable('{{%cohort}}', [
            'id' => $this->primaryKey(),
            'study_id' => $this->integer(),
            'temperature' => $this->string(),
            'dwelling_id' => $this->integer(),
            'animals_per_dwelling' => $this->integer(),
            'control' => $this->boolean(),
            'cohort_size' => $this->integer(),
            'taxonomy_id' => $this->integer(),
            'strain_id' => $this->integer(),
            'site' => $this->string()->comment('place of the experiment'),
            'sex' => $this->string(),
            'age_of_start' => $this->float()->comment('age at start of treatment'),
            'smoothed_lifespan_last_decile_age' => $this->float()->comment('10% of the animals are alive for smoothed survival curve'),
            'smoothed_lifespan_median_age' => $this->float()->comment('50% of the animals are alive for smoothed survival curve'),
            'light_conditions' => $this->string()->comment('in hours, light:dark ("10:14")'),
            'diet_description' => $this->text(),
            'type_of_experiment' => $this->string()->comment('drug / genetic / diet / other'),
            'active_substance_id' => $this->integer(),
            'dosage' => $this->string()->comment('including units and timeliness. Examples of timeliness to favor a common language: once initially, every other week, continuously'),
            'vehicle' => $this->string(),
            'diet_intervention_description' => $this->text(),
            'temperature_unit' => $this->string(),
            'age_unit' => $this->string(),
            'remarks' => $this->text(),
            'health_parameters' => $this->text()->comment('names of health parameters (filled in individual_lifespans), separated by commas'),
            'year' => $this->integer()->comment('year of birth of the cohort'),
            'timestamp' => $this->timestamp(),
        ]);

        $this->createTable('{{%study}}', [
            'id' => $this->primaryKey(),
            'journal' => $this->string(),
            'doi' => $this->string(),
            'pubmed_id' => $this->string()->comment('-1 if not found'),
            'full_text_URL' => $this->string()->comment('for free articles'),
            'email' => $this->string()->comment('submitter\'s email'),
            'authors' => $this->string()->comment('authors names separated by comma'),
            'year' => $this->integer(),
            'remarks' => $this->text(),
            'timestamp' => $this->timestamp(),
        ]);

        $this->createTable('{{%lifespan}}', [
            'id' => $this->primaryKey(),
            'cohort_id' => $this->integer(),
            'age' => $this->integer()->comment('age of death or removal of the animal, one per cell, in age_unit defined in cohort'),
            'status' => $this->string()->comment('dead or removed'),
            'health_measures' => $this->text()->comment('health parameters that are key for lifespan interpretation, as indicated in cohort_lifespans, separated by commas. ex: weight of the animal to judge for crypto-caloric restriction'),
        ]);
        
        $this->addForeignKey('cohort_study', '{{%cohort}}', 'study_id', '{{%study}}', 'id');
        $this->addForeignKey('cohort_taxonomy', '{{%cohort}}', 'taxonomy_id', '{{%taxonomy}}', 'id');
        $this->addForeignKey('cohort_strain', '{{%cohort}}', 'strain_id', '{{%strain}}', 'id');
        $this->addForeignKey('cohort_active_substance', '{{%cohort}}', 'active_substance_id', '{{%active_substance}}', 'id');
        $this->addForeignKey('cohort_dwelling', '{{%cohort}}', 'dwelling_id', '{{%dwelling_type}}', 'id');
        $this->addForeignKey('lifespan_cohort', '{{%lifespan}}', 'cohort_id', '{{%cohort}}', 'id');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('cohort_study', '{{%cohort}}');
        $this->dropForeignKey('cohort_taxonomy', '{{%cohort}}');
        $this->dropForeignKey('cohort_strain', '{{%cohort}}');
        $this->dropForeignKey('cohort_active_substance', '{{%cohort}}');
        $this->dropForeignKey('cohort_dwelling', '{{%cohort}}');
        $this->dropForeignKey('lifespan_cohort', '{{%lifespan}}');
        
        $this->dropTable('{{%lifespan}}');
        $this->dropTable('{{%study}}');
        $this->dropTable('{{%cohort}}');
        $this->dropTable('{{%active_substance}}');
        $this->dropTable('{{%strain}}');
        $this->dropTable('{{%taxonomy}}');
        $this->dropTable('{{%dwelling_type}}');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230222_162322_experiment cannot be reverted.\n";

        return false;
    }
    */
}
