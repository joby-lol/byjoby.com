<?php

use DigraphCMS\Config;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../initialize.php';

// configure staging/prod db names
$staging_db = 'byjobycom_test';
$production_db = 'byjobycom_production';

// connect to PDOs
$pdo = new PDO(
    sprintf('mysql:host=mysql.byjoby.com', $staging_db),
    Config::get('db.user'),
    Config::get('db.pass')
);

// drop all staging tables
echo "Dropping staging tables" . PHP_EOL;
$pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
foreach ($pdo->query(sprintf('SHOW TABLES from `%s`', $staging_db))->fetchAll() as $r) {
    $query = $pdo->prepare(sprintf(
        'DROP TABLE `%s`.`%s`',
        $staging_db,
        $r[0]
    ));
    if ($query->execute()) {
        echo "Dropped staging table " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error dropping staging table " . $r[0] . ': ' . $query->errorInfo());
    }
}

// copy all production tables into staging
echo "Copying production tables to staging" . PHP_EOL;
foreach ($pdo->query(sprintf('SHOW TABLES from `%s`', $production_db))->fetchAll() as $r) {
    // copy table structure
    $query = $pdo->prepare(sprintf(
        'CREATE TABLE `%s`.`%s` LIKE `%s`.`%s`',
        $staging_db,
        $r[0],
        $production_db,
        $r[0]
    ));
    if ($query->execute()) {
        echo "Copied structure from " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error copying table structure " . $r[0] . ': ' . $query->errorInfo());
    }
    // copy table data
    $query = $pdo->prepare(sprintf(
        'INSERT `%s`.`%s` SELECT * FROM `%s`.`%s`',
        $staging_db,
        $r[0],
        $production_db,
        $r[0]
    ));
    if ($query->execute()) {
        echo "Copied data from " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error copying table data " . $r[0] . ': ' . $query->errorInfo());
    }
}
