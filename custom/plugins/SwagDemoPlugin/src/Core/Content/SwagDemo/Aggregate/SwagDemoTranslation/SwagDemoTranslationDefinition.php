<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagDemoPlugin\Core\Content\SwagDemo\SwagDemoDefinition;

class SwagDemoTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'swag_demo_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return SwagDemoDefinition::class;
    }

    public function getEntityClass(): string
    {
        return SwagDemoTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return SwagDemoTranslationCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new StringField('city','city'))->addFlags(new Required()),
        ]);
    }
}
