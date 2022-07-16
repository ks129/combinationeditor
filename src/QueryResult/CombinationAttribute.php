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

namespace PrestaShop\Module\CombinationEditor\QueryResult;

use PrestaShop\PrestaShop\Core\Domain\Product\AttributeGroup\Attribute\ValueObject\AttributeId;
use PrestaShop\PrestaShop\Core\Domain\Product\AttributeGroup\ValueObject\AttributeGroupId;

/**
 * Stores one attribute data for combination
 */
class CombinationAttribute
{
    /**
     * @var array<AttributeId>
     */
    private $attributeIds;

    /**
     * @var AttributeGroupId
     */
    private $attributeGroupId;

    /**
     * @param int $attributeId
     * @param int $attributeGroupId
     */
    public function __construct(array $attributeIds, int $attributeGroupId)
    {
        $this->attributeGroupId = new AttributeGroupId($attributeGroupId);

        foreach ($attributeIds as $attributeId) {
            $this->attributeIds[] = new AttributeId($attributeId);
        }
    }

    /**
     * @return array<AttributeId>
     */
    public function getAttributeIds(): array
    {
        return $this->attributeIds;
    }

    /**
     * @return AttributeGroupId
     */
    public function getAttributeGroupId(): AttributeGroupId
    {
        return $this->attributeGroupId;
    }
}
