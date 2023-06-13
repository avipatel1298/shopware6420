<?php declare(strict_types=1);

namespace ICTECHPromotionIcons\Core\Content\Extentions;

use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class MediaExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new OneToOneAssociationField(
                'uploadPromotionIcon',
                'id',
                'media_id',
                \ICTECHPromotionIcons\Core\Content\UploadPromotion\UploadPromotionDefinition::class,
                false,
            ))->addFlags(new Inherited()),
        );
    }

    public function getDefinitionClass(): string
    {
        return MediaDefinition::class;
    }
}
