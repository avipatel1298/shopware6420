<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1681282323 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1681282323;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement("CREATE TABLE IF NOT EXISTS `first_plugin` (
    `id` BINARY(16) NULL,
    `email` VARCHAR(255) NULL,
    `password` VARCHAR(255) NULL,
    `` BINARY(16) NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`),
    KEY `fk.first_plugin.product_id` (`product_id`,``),
    CONSTRAINT `fk.first_plugin.product_id` FOREIGN KEY (`product_id`,``) REFERENCES `product` (`id`,`version_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $connection->executeStatement("CREATE TABLE IF NOT EXISTS `first_plugin_translation` (
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    `first_plugin_id` BINARY(16) NOT NULL,
    `language_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`first_plugin_id`,`language_id`),
    KEY `fk.first_plugin_translation.first_plugin_id` (`first_plugin_id`),
    KEY `fk.first_plugin_translation.language_id` (`language_id`),
    CONSTRAINT `fk.first_plugin_translation.first_plugin_id` FOREIGN KEY (`first_plugin_id`) REFERENCES `first_plugin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.first_plugin_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
