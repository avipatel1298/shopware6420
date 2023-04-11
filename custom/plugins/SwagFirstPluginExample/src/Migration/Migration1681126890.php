<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1681126890 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1681126890;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement("CREATE TABLE  `first_plugin` (
    `id` BINARY(16) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NULL,
    `password` VARCHAR(255) NULL,
    `product_id` BINARY(16) NULL,
    `product_name` VARCHAR(255) NULL,
    `product_version_id` BINARY(16) NULL,
    `product_number` VARCHAR(255) NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`),
    KEY `fk.first_plugin.product_id` (`product_id`,`product_version_id`),
    CONSTRAINT `fk.first_plugin.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
