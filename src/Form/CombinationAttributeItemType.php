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

namespace PrestaShop\Module\CombinationEditor\Form;

use PrestaShop\Module\CombinationEditor\ChoiceProvider\AttributeGroupChoiceProvider;
use PrestaShop\Module\CombinationEditor\DataProvider\AttributeDataProvider;
use PrestaShopBundle\Form\Admin\Type\IconButtonType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CombinationAttributeItemType extends TranslatorAwareType
{
    /**
     * @var AttributeGroupChoiceProvider
     */
    private $attributeGroupChoiceProvider;

    /**
     * @var AttributeDataProvider
     */
    private $attributeDataProvider;

    /**
     * @var int
     */
    private $langId;

    /**
     * {@inheritdoc}
     * 
     * @param AttributeGroupChoiceProvider $attributeGroupChoiceProvider
     * @param AttributeDataProvider $attributeDataProvider
     * @param int $langId
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        AttributeGroupChoiceProvider $attributeGroupChoiceProvider,
        AttributeDataProvider $attributeDataProvider,
        int $langId
    ) {
        parent::__construct($translator, $locales);

        $this->attributeGroupChoiceProvider = $attributeGroupChoiceProvider;
        $this->attributeDataProvider = $attributeDataProvider;
        $this->langId = $langId;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attribute_group', ChoiceType::class, [
                'choices' => $this->attributeGroupChoiceProvider->getChoices(),
                'required' => false,
            ])
            ->add('remove', IconButtonType::class, [
                'icon' => 'delete',
                'attr' => [
                    'class' => 'text-secondary remove-customization-btn tooltip-link',
                    'data-modal-title' => $this->trans('Delete item', 'Admin.Notifications.Warning'),
                    'data-modal-message' => $this->trans('Are you sure you want to delete this item?', 'Admin.Notifications.Warning'),
                    'data-modal-apply' => $this->trans('Delete', 'Admin.Actions'),
                    'data-modal-cancel' => $this->trans('Cancel', 'Admin.Actions'),
                    'data-toggle' => 'pstooltip',
                    'data-original-title' => $this->trans('Delete', 'Admin.Global'),
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'addAttributesList']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'addAttributesList']);
    }

    /**
     * @param FormEvent $event
     */
    protected function addAttributesList(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();
        $attributes = (isset($data['attribute_group']) && $data['attribute_group'] !== null) ? $this->attributeDataProvider->getAttributes((int) $data['attribute_group'], $this->langId) : [];
        $choices = [];

        foreach ($attributes as $attribute) {
            $choices[$attribute['name']] = (int) $attribute['id_attribute'];
        }

        $form->add('attribute', ChoiceType::class, [
            'choices' => $choices,
            'required' => false,
        ]);
    }
}
