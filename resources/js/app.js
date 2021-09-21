try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');


  require('bootstrap');
} catch (e) { }

window.Swal = require('sweetalert2');
window.Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

require('datatables.net-bs4');
require('datatables.net-buttons-bs4');