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
import ChoiceTable from '@components/choice-table';

const {$} = window;

$(document).ready(() => {
  new ChoiceTable();

  function updateChoices(url, attributeGroupSelect) {
    $.ajax({
      type: 'GET',
      url,
      dataType: 'JSON',
      success: (response) => {
        const groupIndex = attributeGroupSelect.closest('.row').index();
        const attributesTable = attributeGroupSelect.closest('.row').find('div.choice-table table.table tbody');
        attributesTable.html('');

        // No way to get it from each
        let i = 0;

        $.each(response, (key, value) => {
          attributesTable.append(`
            <tr>
              <td>
                <div class="form-check form-check-radio form-checkbox">
                  <div class="md-checkbox md-checkbox-inline">
                    <label>
                      <input type="checkbox" id="combinationeditor_attributes_attributes_${groupIndex}_attribute${i}" name="combinationeditor_attributes[attributes][${groupIndex}][attribute][]" class="form-check-input" value="${value}"/>
                      <i class="md-checkbox-control"></i>
                      ${key}
                    </label>
                  </div>
                </div>
              </td>
            </tr>
          `);
          i += 1;
        });
      },
    });
  }

  $(document).on('change', '.combinationeditor-manager .combinationeditor-attribute-group', (event) => {
    const select = $(event.target);

    // Fetch new attributes data
    updateChoices(select.find(':selected').data('url'), select);
  });

  $(document).on('click', '.combinationeditor-manager .combinationeditor-add-attribute', (event) => {
    event.preventDefault();

    const btn = $(event.target);

    const collection = btn.prev();
    const newForm = $(collection.data('prototype').replace(/__COMBINATION_ATTRIBUTE_INDEX__/g, collection.children().length));
    collection.append(newForm);
    updateChoices(newForm.find('select.combinationeditor-attribute-group :selected').data('url'), newForm.find('select.combinationeditor-attribute-group'));
    window.prestaShopUiKit.init();
  });

  $(document).on('click', '.combinationeditor-manager .combinationeditor-save', (event) => {
    event.preventDefault();
    const btn = $(event.target);

    const form = btn.closest('form[name=combinationeditor_attributes]');

    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      dataType: 'JSON',
      data: form.serialize(),
      success: (response) => {
        if (response.success === false) {
          showErrorMessage(response.message);
        } else {
          showSuccessMessage(response.message);
          form.closest('.row').closest('.panel').find('h2.title:first').text(response.title);
          $(`tr#attribute_${form.data('combinationId')} td:nth-child(3)`).text(response.name);
        }
      },
      error: (xhr) => {
        const errorMessage = `${xhr.status}: ${xhr.statusText}`;
        showErrorMessage(errorMessage);
        console.error(errorMessage);
      },
    });
  });

  $(document).on('click', '.combinationeditor-manager .delete', (event) => {
    event.preventDefault();
    $(event.target).closest('.row').remove();
  });
});
