<?php declare(strict_types=1);

namespace ICTECHPromotionIcons\Util\Lifecycle;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;

class Installation
{
    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $mediaFolderRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $mediaDefaultFolderRepository;


    public function __construct(
        EntityRepositoryInterface $mediaFolderRepository,
        EntityRepositoryInterface $mediaDefaultFolderRepository
    )
    {
        $this->mediaFolderRepository = $mediaFolderRepository;
        $this->mediaDefaultFolderRepository = $mediaDefaultFolderRepository;
    }

    public function installMedia(Context $context): void
    {
        $this->createMediaFolderContent($context);
    }

    private function createMediaFolderContent(Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'Promotion Icon'));
        $MediaUploadRepository = $this->mediaFolderRepository->search($criteria, $context)->getElements();

        if ($MediaUploadRepository == NULL) {
            $defaultFolderId = $this->createDefaultMediaFolder($context);

            $mediaFolderId = Uuid::randomHex();
            $mediaFolder = [
                [
                    'id' => $mediaFolderId,
                    'name' => 'Promotion Icon',
                    'defaultFolderId' => $defaultFolderId,
                    'child_count' => '0',
                    'configuration' => [
                        'id' => Uuid::randomHex(),
                        'createThumbnails' => true,
                        'keepAspectRatio' => true,
                        'thumbnailQuality' => 80,
                    ],
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
                ]
            ];

            try {
                $this->mediaFolderRepository->create($mediaFolder, $context);
            } catch (UniqueConstraintViolationException $exception) {
                throw new \RuntimeException(sprintf('Error: %s', $exception->getMessage()));
            }
        }
    }

    private function createDefaultMediaFolder(Context $context)
    {
        $mediaDefaultFolderId = Uuid::randomHex();
        $mediaDefaultFolder = [
            [
                'id' => $mediaDefaultFolderId,
                'associationFields' => [],
                'entity' => 'ict_upload_promotion_icon',
                'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
            ]
        ];
        try {
            $this->mediaDefaultFolderRepository->create($mediaDefaultFolder, $context);
        } catch (UniqueConstraintViolationException $exception) {
            throw new \RuntimeException(sprintf('Error: %s', $exception->getMessage()));
        }
        return $mediaDefaultFolderId;
    }

    public function uninstallMedia(Context $context): void
    {
        $this->removeMediaData($context);
    }

    private function removeMediaData(Context $context): void
    {
        $mediaFolderId = $this->getMediaFolderId($context);
        $mediaDefaultFolderId = $this->getMediaDefaultFolderId($context);
        if (!$mediaFolderId) {
            return;
        }
        $this->mediaFolderRepository->delete([
            ['id' => $mediaFolderId]
        ], $context);

        if (!$mediaDefaultFolderId) {
            return;
        }
        $this->mediaDefaultFolderRepository->delete([
            ['id' => $mediaDefaultFolderId]
        ], $context);
    }

    private function getMediaFolderId(Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'Promotion Icon'));
        return $this->mediaFolderRepository->searchIds($criteria, $context)->firstId();
    }

    private function getMediaDefaultFolderId(Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('entity', 'ict_upload_promotion_icon'));
        return $this->mediaDefaultFolderRepository->searchIds($criteria, $context)->firstId();
    }

}
