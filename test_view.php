<?php require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
try { echo view('landing')->render(); } catch (Exception $e) { echo 'ERROR: ' . $e->getMessage(); }
