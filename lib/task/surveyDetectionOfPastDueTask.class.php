<?php

class surveyDetectionOfPastDueTask extends sfBaseTask {

    protected function configure() {
        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace = 'survey';
        $this->name = 'detection-of-past-due';
        $this->briefDescription = 'Detection of past due surveys.';
        $this->detailedDescription = <<<EOF
The [survey:detection-of-past-due|INFO] task does things.
Call it with:

  [php symfony survey:detection-of-past-due|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
        
        // Set flag for all past due my surveys
        $past_due_my_surveys = Doctrine_Core::getTable("LtMySurvey")->setFlagForPastDueMySurveys();
        
        $this->logSection('Logs', sprintf('Amount of past due surveys: %d', $past_due_my_surveys));
    }

}
