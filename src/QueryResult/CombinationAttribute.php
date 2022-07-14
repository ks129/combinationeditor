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
     * @var AttributeId
     */
    private $attributeId;

    /**
     * @var AttributeGroupId
     */
    private $attributeGroupId;

    /**
     * @param int $attributeId
     * @param int $attributeGroupId
     */
    public function __construct(int $attributeId, int $attributeGroupId)
    {
        $this->attributeId = new AttributeId($attributeId);
        $this->attributeGroupId = new AttributeGroupId($attributeGroupId);
    }

    /**
     * @return AttributeId
     */
    public function getAttributeId(): AttributeId
    {
        return $this->attributeId;
    }

    /**
     * @return AttributeGroupId
     */
    public function getAttributeGroupId(): AttributeGroupId
    {
        return $this->attributeGroupId;
    }
}
