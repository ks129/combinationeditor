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

namespace PrestaShop\Module\CombinationEditor\Command;

use PrestaShop\PrestaShop\Core\Domain\Product\AttributeGroup\Attribute\ValueObject\AttributeId;
use PrestaShop\PrestaShop\Core\Domain\Product\Combination\ValueObject\CombinationId;

/**
 * Responsible for editing combination's attributes
 */
class SetCombinationAttributesCommand
{
    /**
     * @var CombinationId
     */
    private $combinationId;

    /**
     * @var array<AttributeId>
     */
    private $attributeIds;

    /**
     * @param int $combinationId
     */
    public function __construct(int $combinationId)
    {
        $this->combinationId = new CombinationId($combinationId);
    }

    /**
     * @return CombinationId
     */
    public function getCombinationId(): CombinationId
    {
        return $this->combinationId;
    }

    /**
     * @return array<AttributeId>
     */
    public function getAttributeIds(): array
    {
        return $this->attributeIds;
    }

    /**
     * @param array<int> $attributeIds
     *
     * @return self
     */
    public function setAttributeIds(array $attributeIds): self
    {
        $this->attributeIds = array_map(function (int $id) { return new AttributeId($id); }, $attributeIds);

        return $this;
    }
}
