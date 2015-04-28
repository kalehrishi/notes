<?php
// Settings to make all errors more obvious during testing
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');
use Notes\Demo\WebTestCase;
//define('PROJECT_ROOT', realpath(__DIR__ . '/..'));
require_once 'vendor/autoload.php';
// Initialize our own copy of the slim application
class LocalWebTestCase extends WebTestCase {
    public function getSlimInstance() {
      $application = new \Slim\Slim(array(
          'version'        => '0.0.0',
          'debug'          => false,
          'mode'           => 'testing',
        ));
      // Include our core application file
      require  '/vagrant/app/app.php';
      return $application;
    }
};
/* End of file bootstrap.php */