<?php
/**
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author    Karlis Suvi
*  @copyright 2022 Karlis Suvi
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

declare(strict_types=1);

namespace PrestaShop\Module\CombinationEditor\Form\DataProvider;

use PrestaShop\Module\CombinationEditor\Query\GetCombinationAttributes;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

/**
 * Provides data for combination attributes editor.
 */
final class CombinationAttributesDataProvider implements FormDataProviderInterface
{
    /**
     * @var CommandBusInterface
     */
    private $queryBus;

    /**
     * @param CommandBusInterface $queryBus
     */
    public function __construct(CommandBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($id): array
    {
        $combinationAttributes = $this->queryBus->handle(new GetCombinationAttributes((int) $id));
        $data = [
            'attributes' => [],
        ];

        foreach ($combinationAttributes->getCombinationAttributes() as $combinationAttribute) {
            $data['attributes'][] = [
                'attribute_group' => $combinationAttribute->getAttributeGroupId(),
                'attribute' => $combinationAttribute->getAttributeId(),
            ];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     *
     * Not used. Just to match with interface.
     */
    public function getDefaultData(): array
    {
        return [];
    }
}
