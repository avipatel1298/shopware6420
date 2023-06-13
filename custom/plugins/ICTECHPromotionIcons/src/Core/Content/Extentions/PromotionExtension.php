<?php declare(strict_types=1);

namespace ICTECHPromotionIcons\Core\Content\Extentions;

use ICTECHPromotionIcons\Core\Content\UploadPromotion\UploadPromotionDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class PromotionExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new OneToOneAssociationField(
                'promotionId',
                'id',
                'promotion_id',
                UploadPromotionDefinition::class,
                false
            ))->addFlags(new CascadeDelete()),
        );
    }

    public function getDefinitionClass(): string
    {
        return \Shopware\Core\Checkout\Promotion\PromotionDefinition::class;
    }
}
