<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagFirstPluginExample\Core\Content\FirstPlugin\Aggregate\FirstPluginTranslation\FirstPluginTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'firstPluginId',
                FirstPluginTranslationDefinition::class,
                'name')
        );
    }

    public function getDefinitionClass(): string
    {
       return LanguageDefinition::class;
    }

}
