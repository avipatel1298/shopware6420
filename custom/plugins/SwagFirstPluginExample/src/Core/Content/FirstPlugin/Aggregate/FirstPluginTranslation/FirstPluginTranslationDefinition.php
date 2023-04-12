<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin\Aggregate\FirstPluginTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagFirstPluginExample\Core\Content\FirstPlugin\FirstPluginDefinition;

class FirstPluginTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'first_plugin_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return FirstPluginDefinition::class;
    }

    public function getEntityClass(): string
    {
        return FirstPluginTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return FirstPluginTranslationCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
        ]);
    }
}
