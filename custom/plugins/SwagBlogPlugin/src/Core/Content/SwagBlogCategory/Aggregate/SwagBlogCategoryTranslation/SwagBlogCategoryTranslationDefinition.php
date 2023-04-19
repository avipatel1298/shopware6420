<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\SwagBlogCategoryDefinition;

class SwagBlogCategoryTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'swag_blog_category_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return SwagBlogCategoryDefinition::class;
    }

//    public function getEntityClass(): string
//    {
//        return SwagBlogTranslationEntity::class;
//    }
//
//    public function getCollectionClass(): string
//    {
//        return SwagBlogTranslationCollection::class;
//    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('category_name',
                'category_name'))->addFlags(new Required()),

        ]);
    }

}
