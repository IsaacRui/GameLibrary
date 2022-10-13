// con esta constante llamamos al tooltip que está en DOM para poder mostrar un mensaje al pasar el cursor sobre un botón o cualquier elemento que contenga "tooltip"
const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
// con esta constante llamamos a la constante anterior y hacemos una funcion flecha apra llamar al elemento de bootstrap.tootltip
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

// Aquí intente hacer un ojo que mostrara la contraseña pero no lo logré hacer...

// $(document).ready(function() {
//     $("#show_hide a").on('click', function(event) {
//         event.preventDefault();
//         if($('#show_hide input').attr("type") == "text"){
//             $('#show_hide input').attr('type', 'password');
//             $('#show_hide i').addClass( "fa-eye-slash" );
//             $('#show_hide i').removeClass( "fa-eye" );
//         }else if($('#show_hide input').attr("type") == "password"){
//             $('#show_hide input').attr('type', 'text');
//             $('#show_hide i').removeClass( "fa-eye-slash" );
//             $('#show_hide i').addClass( "fa-eye" );
//         }
//     });
// });
