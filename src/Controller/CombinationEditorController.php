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

namespace PrestaShop\Module\CombinationEditor\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CombinationEditorController extends FrameworkBundleAdminController
{
    /**
     * Returns list of given attribute group attributes for dropdown.
     */
    public function getAttributesAction(Request $request, int $attributeGroupId): JsonResponse
    {
        $attributeDataProvider = $this->get('prestashop.module.combinationeditor.data_provider.attribute_data_provider');
        $choices = [];
        $langId = $this->get('prestashop.adapter.legacy.context')->getLanguage()->id;

        foreach ($attributeDataProvider->getAttributes($attributeGroupId, (int) $langId) as $attribute) {
            $choices[$attribute['name']] = (int) $choices['id_attribute'];
        }

        return new JsonResponse($choices);
    }
}
