<?php

use DigraphCMS\Config;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../initialize.php';

// only works on mysql
if (Config::get('db.adapter') !== 'mysql') {
    throw new \Exception("This script only works for MySQL databases");
}

// get username/password from config
$user = Config::get('db.user');
$pass = Config::get('db.pass');
// configure staging/prod db names
$staging_db = 'byjobycom_test';
$production_pdo = 'byjobycom_production';

// connect to PDOs
$staging_pdo = new PDO(
    sprintf('mysql:host=mysql.byjoby.com;dbname=%s', $staging_db),
    $user,
    $pass
);
$production_pdo = new PDO(
    sprintf('mysql:host=mysql.byjoby.com;dbname=%s', $staging_db),
    $user,
    $pass
);

// drop all staging tables
$staging_pdo->beginTransaction();
$staging_pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
foreach ($staging_pdo->query('SHOW TABLES')->fetchAll() as $r) {
    $query = $staging_pdo->prepare('DROP TABLE ' . $r[0]);
    if ($query->execute()) {
        echo "Dropped staging table " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error dropping staging table " . $r[0] . ': ' . $query->errorInfo());
    }
}
$staging_pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
$staging_pdo->commit();

// copy all production tables into staging
$production_pdo->beginTransaction();
$production_pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
foreach ($production_pdo->query('SHOW TABLES')->fetchAll() as $r) {
    // copy table structure
    $query = $production_pdo->prepare(sprintf(
        'CREATE TABLE `%s`.`%s` LIKE `%s`.`%s`',
        $staging_db,
        $r[0],
        $production_pdo,
        $r[0]
    ));
    if ($query->execute()) {
        echo "Copied table structure " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error copying table structure " . $r[0] . ': ' . $query->errorInfo());
    }
    // copy table data
    $query = $production_pdo->prepare(sprintf(
        'INSERT `%s`.`%s` SELECT * FROM `%s`.`%s`',
        $staging_db,
        $r[0],
        $production_pdo,
        $r[0]
    ));
    if ($query->execute()) {
        echo "Copied table structure " . $r[0] . PHP_EOL;
    } else {
        throw new \Exception("Error copying table structure " . $r[0] . ': ' . $query->errorInfo());
    }
}
$production_pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
$production_pdo->commit();
