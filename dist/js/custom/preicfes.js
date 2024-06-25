$(document).ready(() => {
  /* Mascaras de entrada para campos de formulario */

  $('#guardar-simul').on('submit', async (e) => {
    e.preventDefault();

    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

    const formData = new FormData(e.target);

    try {
      const response = await fetch('../modelos/preicfes-modelo.php', {
        method: e.target.method,
        body: formData,
        // Opcionalmente, puedes agregar cabeceras si es necesario
      });

      if (!response.ok) {
        throw new Error('La respuesta de la red no fue válida');
      }

      const data = await response.json();

      if (data.respuesta === 'exito') {
        $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
        Swal.fire({
          position: "center",
          icon: "success",
          title: data.comentario,
          showConfirmButton: false,
          timer: 1500,
        });

        location.reload();
        // window.location.href = 'av-asignaciones-lista.php?grado=' + data.grado;
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.comentario,
        });
      }
      
    } catch (error) {
      console.error('Error:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ocurrió un error al procesar la solicitud',
      });
    }
  });


  document.getElementById('respuestas_simulacro').addEventListener('submit', async (e) => {
    e.preventDefault();
  
    document.getElementById('cortina-de-espera').style.overflowY = 'auto';
    document.getElementById('cortina-de-espera').style.display = 'flex';
  
    const formData = new FormData(e.target);
  
    try {
      const response = await fetch('../modelos/preicfes-modelo.php', {
        method: e.target.method,
        body: formData,
      });
  
      if (!response.ok) {
        throw new Error('La respuesta de la red no fue válida');
      }
  
      const data = await response.json();
      console.log(data);
  
      if (data.respuesta === 'exito') {

        document.getElementById('cortina-de-espera').style.overflowY = 'auto';
        document.getElementById('cortina-de-espera').style.display = 'none';

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Respuestas guardadas con éxito',
          showConfirmButton: false,
          timer: 1500,
        });
  
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un error',
        });
      }
  
    } catch (error) {
      console.error('Error:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ocurrió un error al procesar la solicitud',
      });
    } finally {
      document.getElementById('cortina-de-espera').style.overflowY = 'auto';
      document.getElementById('cortina-de-espera').style.display = 'none';
    }

  });
  


});
