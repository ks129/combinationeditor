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
  $('.combinationeditor-manager .combinationeditor-attribute-group').change((event) => {
    event.preventDefault();

    // Fetch new attributes data
    $.ajax({
      type: 'GET',
      url: $(this).data('url'),
      success: (response) => {
        console.log(response);
      },
    });
  });

  $('.combinationeditor-manager .combinationeditor-add-attribute').click((event) => {
    event.preventDefault();
  });

  $('.combinationeditor-manager .combinationeditor-save').click((event) => {
    event.preventDefault();
  });

  $('.combinationeditor-manager .delete').click((event) => {
    event.preventDefault();
  });
});
