<?php declare(strict_types=1);

namespace ICTECHPromotionIcons;

use Doctrine\DBAL\Connection;
use ICTECHPromotionIcons\Util\Lifecycle\Installation;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class ICTECHPromotionIcons extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
        $this->getMediaFolder()->installMedia($installContext->getContext());
    }

    private function getMediaFolder() : Installation
    {
        /** @var EntityRepositoryInterface $mediaFolderRepository */
        $mediaFolderRepository = $this->container->get('media_folder.repository');

        /** @var EntityRepositoryInterface $mediaDefaultFolderRepository */
        $mediaDefaultFolderRepository = $this->container->get('media_default_folder.repository');

        return new Installation(
            $mediaFolderRepository,
            $mediaDefaultFolderRepository
        );
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        if ($uninstallContext->keepUserData()) {
            return;
        }
        $connection = $this->container->get(Connection::class);
        $connection->executeUpdate('DROP TABLE IF EXISTS `ict_upload_promotion_icon`');

        $this->getMediaFolder()->uninstallMedia($uninstallContext->getContext());
    }

}
