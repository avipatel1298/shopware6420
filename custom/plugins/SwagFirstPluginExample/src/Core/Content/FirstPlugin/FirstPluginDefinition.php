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
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;


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
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new StringField('email', 'email')),
            (new StringField('password', 'password')),
            (new FkField('product_id', 'productId', ProductDefinition::class)),
            (new StringField('product_name', 'product_name')),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware()),
            (new StringField('product_number', 'product_number')),

            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id'),

        ]);
    }
}
