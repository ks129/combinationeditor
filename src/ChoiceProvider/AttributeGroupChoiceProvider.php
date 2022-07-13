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

namespace PrestaShop\Module\CombinationEditor\ChoiceProvider;

use PrestaShop\Module\CombinationEditor\DataProvider\AttributeGroupDataProvider;
use PrestaShop\PrestaShop\Core\Form\FormChoiceProviderInterface;

final class AttributeGroupChoiceProvider implements FormChoiceProviderInterface
{
    /**
     * @var AttributeGroupDataProvider
     */
    private $attributeGroupDataProvider;

    /**
     * @var int
     */
    private $langId;

    /**
     * @param AttributeGroupDataProvider $attributeGroupDataProvider
     * @param int $langId
     */
    public function __construct(AttributeGroupDataProvider $attributeGroupDataProvider, int $langId)
    {
        $this->attributeGroupDataProvider = $attributeGroupDataProvider;
        $this->langId = $langId;
    }

    /**
     * {@inheritdoc}
     */
    public function getChoices()
    {
        $choices = [];
        $attributeGroups = $this->attributeGroupDataProvider->getAttributeGroups($this->langId);

        foreach ($attributeGroups as $attributeGroup) {
            $choices[$attributeGroup['name']] = (int) $attributeGroup['id_attribute_group'];
        }

        return $choices;
    }
}
