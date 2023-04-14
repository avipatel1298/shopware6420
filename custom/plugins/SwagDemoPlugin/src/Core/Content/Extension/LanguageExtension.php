<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation\SwagDemoTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'swagDemoTranslationsId',
                SwagDemoTranslationDefinition::class,
                'name',
                'id'),
        );

        $collection->add(
            new OneToManyAssociationField(
                'swagDemoTranslationsId',
                SwagDemoTranslationDefinition::class,
                'city',
                'id'),
        );

    }

    public function getDefinitionClass(): string
    {
        return LanguageDefinition::class;
    }

}

