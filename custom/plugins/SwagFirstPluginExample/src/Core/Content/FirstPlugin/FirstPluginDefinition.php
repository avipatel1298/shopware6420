<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
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

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('name','name'))->addFlags(new Required()),
            (new StringField('email','email')),
            (new StringField('password','password'))
        ]);
    }
}
