<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\SwagBlogDefinition;

class SwagBlogTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'swag_blog_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return SwagBlogDefinition::class;
    }
//
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
            (new StringField('blog_name', 'blog_name'))->addFlags(new Required()),
            (new StringField('discription','discription'))->addFlags(new Required()),
        ]);
    }

}
