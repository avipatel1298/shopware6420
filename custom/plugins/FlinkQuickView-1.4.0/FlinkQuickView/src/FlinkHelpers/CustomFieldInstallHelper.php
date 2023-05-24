<?php declare(strict_types=1);

namespace Flink\QuickView\FlinkHelpers;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\IdSearchResult;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomFieldInstallHelper
{

    /**
     * @var string|null
     */
    protected $commonIdentifier = null;

    /**
     * @var EntityRepositoryInterface|null
     */
    protected $customFieldRepository = null;

    /**
     * @var EntityRepositoryInterface|null
     */
    protected $customFieldSetRepository = null;

    /**
     * @var ContainerInterface|null
     */
    protected $container = null;

    /**
     * @var Context|null
     */
    protected $context = null;

    /**
     * @var array
     */
    protected $newCustomFieldSets = [];

    /**
     * @var IdSearchResult|null
     */
    protected $installedFieldSetIds = null;

    /**
     * @var IdSearchResult|null
     */
    protected $installedFieldIds = null;

    /**
     * CustomFieldInstallHelper constructor.
     * @param string $commonIdentifier
     * @param ContainerInterface $container
     * @param Context $context
     * @throws \Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException
     */
    public function __construct(string $commonIdentifier, ContainerInterface $container, Context $context)
    {
        $this->commonIdentifier = $commonIdentifier;
        $this->container = $container;
        $this->context = $context;
        $this->customFieldRepository = $this->container->get('custom_field.repository');
        $this->customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $this->loadCustomFieldSetIds();
        $this->loadCustomFieldIds();
    }

    /**
     * Add a field set to be installed
     * @param string $name
     * @param array $label
     * @param array $entities
     * @return CustomFieldInstallHelper
     */
    public function addFieldSet(string $name, array $label, array $entities): CustomFieldInstallHelper
    {
        $this->newCustomFieldSets[$this->addPrefix($name)] = [
            'name' => $this->addPrefix($name),
            'config' => [
                'label' => $label
            ],
            'relations' => array_map(function($entity) { return ['entityName' => $entity]; }, $entities),
            'customFields' => []
        ];

        return $this;
    }

    /**
     * Add a field to be installed
     * @param string $set
     * @param string $name
     * @param string $type
     * @param array $label
     * @param array $placeholder
     * @param string $componentName
     * @param int $position
     * @param array $additional
     * @return CustomFieldInstallHelper
     */
    public function addField(string $set, string $name, string $type, array $label, array $placeholder = [], string $componentName = 'sw-field', int $position = 1, $additional = []): CustomFieldInstallHelper
    {
        $set = $this->addPrefix($set);
        $name = $this->addPrefix($name, $set);


        $this->newCustomFieldSets[$set]['customFields'][] = [
            'name' => $name,
            'type' => $type,
            'config' => array_merge([
                'componentName' => $componentName,
                'customFieldType' => $type,
                'customFieldPosition' => $position,
                'label' => $label,
                'placeholder' => $placeholder,
            ], $additional)
        ];

        return $this;
    }

    /**
     * Installs all added fields and field sets
     * @return void
     */
    public function install(): void
    {
        if ($this->hasCustomFields() || $this->hasCustomFieldSets()) {
            $this->uninstall();
        }

        $fieldSets = array_values($this->newCustomFieldSets);
        $this->customFieldSetRepository->create($fieldSets, $this->context);
    }

    /**
     * Removes all installed fields and field sets that use the common identifier.
     * @return void
     */
    public function uninstall(): void
    {
        $this->uninstallFields();
        $this->uninstallFieldSets();
    }

    /**
     * Add the common identifier (or a custom string) as a prefix separated by an underscore to a string,
     * But only, if the prefix is not already at the start of the string
     * @param string $string
     * @param string $prefix
     * @return string
     */
    private function addPrefix(string $string, $prefix = ''): string
    {
        $prefix = $prefix ?: $this->commonIdentifier;
        if (strpos($string, $prefix . '_') === 0) {
            return $string;
        }

        return $prefix . '_' . $string;
    }

    /**
     * Get the search criteria for searching for fields and field sets based on the common identifier
     * @return Criteria
     * @throws \Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException
     */
    private function getSearchCriteria(): Criteria
    {
        $criteria = new Criteria();
        $criteria->addFilter(new ContainsFilter('name', $this->commonIdentifier));
        return $criteria;
    }

    /**
     * Loads all installed fields that use the common identifier.
     * @throws \Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException
     */
    private function loadCustomFieldIds(): void
    {
        $this->installedFieldIds = $this->customFieldRepository->searchIds($this->getSearchCriteria(), $this->context);
    }

    /**
     * Loads all installed field sets that use the common identifier.
     * @throws \Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException
     */
    private function loadCustomFieldSetIds(): void
    {
        $this->installedFieldSetIds = $this->customFieldSetRepository->searchIds($this->getSearchCriteria(), $this->context);
    }

    /**
     * Checks if there are already any fields installed.
     * @return bool
     */
    private function hasCustomFields(): bool
    {
        return $this->installedFieldIds && $this->installedFieldIds->getTotal() !== 0;
    }

    /**
     * Checks if there are already any field sets installed.
     * @return bool
     */
    private function hasCustomFieldSets(): bool
    {
        return $this->installedFieldIds && $this->installedFieldIds->getTotal() !== 0;
    }

    /**
     * Removes all installed fields that use the common identifier.
     * @return void
     */
    private function uninstallFields(): void
    {
        if ($this->hasCustomFields()) {

            $ids = array_map(function ($id) {
                return ['id' => $id];
            }, $this->installedFieldIds->getIds());

            $this->customFieldRepository->delete($ids, $this->context);

        }
    }

    /**
     * Removes all installed field sets that use the common identifier.
     * @return void
     */
    private function uninstallFieldSets(): void
    {
        if ($this->hasCustomFieldSets()) {

            $ids = array_map(function ($id) {
                return ['id' => $id];
            }, $this->installedFieldSetIds->getIds());

            $this->customFieldSetRepository->delete($ids, $this->context);

        }
    }
}
