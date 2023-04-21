<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\SwagBlogTranslationCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\SwagBlogTranslationEntity;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\BlogCategoryDefinition;

class BlogCategoryTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'blog_category_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return BlogCategoryDefinition::class;
    }

    public function getEntityClass(): string
    {
        return BlogCategoryTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BlogCategoryTranslationCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('category_name',
                'categoryName'))->addFlags(new Required()),

        ]);
    }

}
