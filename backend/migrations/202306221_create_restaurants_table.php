<?php

return [
    "up" => function($pdo) {
        $createTableSql = "
            CREATE TABLE `restaurants` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `url` VARCHAR(255) NOT NULL,
                `html` MEDIUMTEXT,
                `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        $pdo->exec($createTableSql);

        $restaurants = [
            ['name' => 'Karloveská klubovňa', 'url' => 'https://www.nasaklubovna.sk/klubovne/karloveska/menu/denne-menu/'],
            ['name' => 'Eat & Meet', 'url' => 'http://eatandmeet.sk/tyzdenne-menu'],
            ['name' => 'Venza', 'url' => 'https://www.novavenza.sk/tyzdenne-menu'],
        ];

        $insertSql = "INSERT INTO `restaurants` (`name`, `url`) VALUES (:name, :url)";

        $stmt = $pdo->prepare($insertSql);
        
        foreach ($restaurants as $restaurant) {
            $stmt->execute([
                'name' => $restaurant['name'],
                'url' => $restaurant['url'],
            ]);
        }
    },
    
    "down" => "DROP TABLE `restaurants`"
];
