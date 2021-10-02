/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.btn-logout').on('click', function (e) {
  e.preventDefault();
  $('#form-logout').trigger('submit');
});
