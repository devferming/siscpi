const form = document.querySelector('#user_login');
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  try {
    const data = new FormData(form);
    const response = await fetch(form.action, {
      method: form.method,
      body: data
    });
    const resultado = await response.json();
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 8000
    });
    if (resultado.respuesta === 'aprobado') {
      switch (resultado.nivel) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        case 7:
        case 8:
          Toast.fire({
            icon: 'success',
            title: `Bienvenido(a) ${resultado.usuario}.`
          });
          setTimeout(() => {
            window.location.href = '../index.php';
          }, 2000);
          break;
        default:
          throw new Error('Invalid level');
      }
    } else if (resultado.respuesta === 'bloqueado') {
      Toast.fire({
        icon: 'error',
        title: 'Usuario bloqueado'
      });
    } else if (resultado.respuesta === 'advertencia') {
      Toast.fire({
        icon: 'warning',
        title: '¡Password Incorrecto!'
      });
    } else if (resultado.respuesta === 'nouser') {
      Toast.fire({
        icon: 'warning',
        title: '¡Usuario Incorrecto!'
      });
    } else {
      throw new Error('Invalid response');
    }
  } catch (err) {
    console.error(err);
    Toast.fire({
      icon: 'error',
      title: 'Algo salió mal'
    });
  }
});
