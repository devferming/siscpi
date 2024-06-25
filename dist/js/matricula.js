$(document).ready(function(){


/*Mascaras de entrada para campos de formulario*/

        $(".bloquear").on('paste', function(e){
          e.preventDefault();
        })
        
        $(".bloquear").on('copy', function(e){
          e.preventDefault();
        })
        
        const number = document.querySelector('.number');

        function formatNumber (n) {
          n = String(n).replace(/\D/g, "");
          return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
          const element = e.target;
          const value = element.value;
          element.value = formatNumber(value);
        });
        

        $(".letter").bind('keypress', function(event) {
          var regex = new RegExp("^[a-zA-Z ]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
          }
        });

        $(".number").bind('keypress', function(event) {
          var regex = new RegExp("^[0-9\. ]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
          }
        });

        $(".direccion").bind('keypress', function(event) {
          var regex = new RegExp("^[a-zA-Z0-9\ #-]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
          }
        });

        $(".correo").bind('keypress', function(event) {
          var regex = new RegExp("^[a-zA-Z0-9\ @_.-]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
          }
        });


/*Validador de formulario*/

        (function() {
          'use strict';
          window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');
          var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          
          } else {

            event.preventDefault();
            var datos = $('#mat_nueva').serializeArray();
      
           $.ajax({
              data:  datos, //datos que se envian a traves de ajax
              url:   $(this).attr('action'), //archivo que recibe la peticion
              type:  'post', //método de envio
              dataType: 'json',
              success: function(data){
                console.log(data);
                var resultado = data;
                console.log(resultado.respuesta);
                
                
                if(resultado.respuesta == 'exito'){
                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Alumnos registrado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                  })} else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Algo salió mal'
                    })
                }
              }  });
      

          }
          form.classList.add('was-validated');
          }, false);
          });
          }, false);
          })();


        


  /*Modales de respuesta*/





/*
  $('#mat_nueva').on('submit', function(e) {

});
*/



   /*     
      $('#mat_nueva').on('submit', function(e) {
      e.preventDefault();
    
          var datos = $(this).serializeArray();
    
          $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
              console.log(data);
              var resultado = data;
              if(resultado.respuesta == 'exito'){
                Swal.fire(
                  'Correcto',
                  'El administrador se actualizo correctamente',
                  'success'
                )
              } else {
                Swal.fire({
                  type: 'error',
                  title: 'Error',
                  text: 'Hubo un error',
                })
              }
            }
    
    });
    
    





/*
          Swal.fire({
            title: '¿Estas seguro?',
            text: "No podrás deshacer esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.value) {
              Swal.fire(
                '¡Exito!',
                'Matricula creada correctamente',
                'success'
              )
            }
          })
        
*/




});
