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
const {$} = window;

$(document).ready(() => {
  $(document).on('change', '.combinationeditor-manager .combinationeditor-attribute-group', (event) => {
    const select = $(event.target);
    // Fetch new attributes data
    $.ajax({
      type: 'GET',
      url: select.find(':selected').data('url'),
      dataType: 'JSON',
      success: (response) => {
        const attributesSelect = select.closest('.row').find('.combinationeditor-attribute');
        attributesSelect.html('');

        $.each(response, (key, value) => {
          attributesSelect.append(`<option value="${value}">${key}</option>`);
        });
      },
    });
  });

  $(document).on('click', '.combinationeditor-manager .combinationeditor-add-attribute', (event) => {
    event.preventDefault();

    const collection = $('ul.attributes-collection');
    const newForm = collection.data('prototype').replace(/__COMBINATION_ATTRIBUTE_INDEX__/g, collection.children().length);
    collection.append(`<li>${newForm}</li>`);
    window.prestaShopUiKit.init();
  });

  $(document).on('click', '.combinationeditor-manager .combinationeditor-save', (event) => {
    event.preventDefault();
    const btn = $(event.target);

    const form = btn.closest('form[name=combination_attributes]');
    console.log(form.serializeArray());
  });

  $(document).on('click', '.combinationeditor-manager .delete', (event) => {
    event.preventDefault();
    $(event.target).closest('.row').remove();
  });
});
