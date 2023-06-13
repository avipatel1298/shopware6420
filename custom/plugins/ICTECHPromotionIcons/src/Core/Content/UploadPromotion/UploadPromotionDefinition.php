<?php declare(strict_types=1);

namespace ICTECHPromotionIcons\Core\Content\UploadPromotion;

use Shopware\Core\Checkout\Promotion\PromotionDefinition;
use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class UploadPromotionDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'ict_upload_promotion_icon';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return UploadPromotionCollection::class;
    }

    public function getEntityClass(): string
    {
        return UploadPromotionEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection(
            [
                (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),

                (new FkField('media_id', 'mediaId', MediaDefinition::class,'id'))->addFlags(new Required()),

                (new FkField('promotion_id', 'promotionId', PromotionDefinition::class,'id'))->addFlags(new Required()),

                (new  OneToOneAssociationField(
                    'promotion',
                    'promotion_id',
                    'id',
                    PromotionDefinition::class
                )),
                (new OneToOneAssociationField(
                    'media',
                    'media_id',
                    'id',
                    MediaDefinition::class
                )),
            ]
        );
    }
}
