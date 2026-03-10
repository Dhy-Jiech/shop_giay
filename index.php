<?php
// index.php
session_start();

// Require config and core files
require_once 'config/database.php';
require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Model.php';

// Initialize the App router
$app = new App();
