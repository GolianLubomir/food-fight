<?php

require 'config.php';

$pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `run_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$migrations = glob('migrations/*.php');

foreach ($migrations as $file) {
    $migration = basename($file, '.php');

    $exists = $pdo->query("SELECT * FROM `migrations` WHERE `migration` = '$migration'")->fetch();

    if (!$exists) {
        $migrationScript = require $file;

        $upMigration = $migrationScript['up'];

        if (is_callable($upMigration)) {
            $upMigration($pdo);
        } else {
            $pdo->exec($upMigration);
        }

        $pdo->exec("INSERT INTO `migrations` (`migration`) VALUES ('$migration')");
        
        echo "Migration {$migration} executed successfully.\n";
    }
}
