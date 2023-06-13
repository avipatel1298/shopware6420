<?php declare(strict_types=1);

namespace ICTECHPromotionIcons\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1683095992 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1683095992;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement("CREATE TABLE `ict_upload_promotion_icon` (
            `id` BINARY(16) NOT NULL,
            `media_id` BINARY(16) NOT NULL,
            `promotion_id` BINARY(16) NOT NULL,
            `created_at` DATETIME(3) NOT NULL,
            `updated_at` DATETIME(3) NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
