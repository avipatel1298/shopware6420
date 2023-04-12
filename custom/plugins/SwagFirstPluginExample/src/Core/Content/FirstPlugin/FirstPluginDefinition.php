<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagFirstPluginExample\Core\Content\FirstPlugin\Aggregate\FirstPluginTranslation\FirstPluginTranslationDefinition;


class FirstPluginDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'first_plugin';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return FirstPluginEntity::class;
    }

    public function getCollectionClass(): string
    {
        return FirstPluginCollection::class;
    }

    //Data Fields to be inserted into database
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('email', 'email')),
            (new StringField('password', 'password')),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new ApiAware(), new Required()),
            (new ReferenceVersionField(ProductDefinition::class,'',))->addFlags(new ApiAware(), new Inherited()),
            (new TranslatedField('name'))->addFlags(new ApiAware()),
            new ManyToOneAssociationField('productId', 'product_id', ProductDefinition::class, 'id'),

            (new TranslationsAssociationField(
                FirstPluginTranslationDefinition::class,'first_plugin_id'))->addFlags(new ApiAware(), new Required()),


        ]);
    }
}
