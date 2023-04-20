<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\BlogDefinition;

class BlogTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'blog_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return BlogDefinition::class;
    }

//    public function getEntityClass(): string
//    {
//        return BlogTranslationEntity::class;
//    }
//
//    public function getCollectionClass(): string
//    {
//        return BlogTranslationCollection::class;
//    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('blog_name', 'blogName'))->addFlags(new Required()),
            (new StringField('description','description'))->addFlags(new Required()),
        ]);
    }

}
