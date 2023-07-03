<?php

return [
    "up" => "CREATE TABLE `foods` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `price` VARCHAR(255) NOT NULL,
        `menu` VARCHAR(255),
        `allergens` VARCHAR(255),
        `restaurant_id` INT NOT NULL,
        `day` INT,
        `src_image` VARCHAR(255),
        FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants`(`id`)
    );",
    
    "down" => "DROP TABLE `foods`;"
];
