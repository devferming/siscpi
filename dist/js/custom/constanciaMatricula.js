document.addEventListener("DOMContentLoaded", function () {
  // Función para convertir una imagen en base64

  function convertirImagenABase64(archivo) {
    return new Promise((resolve, reject) => {
      const lector = new FileReader();
      lector.onloadend = function () {
        resolve(lector.result);
      };
      lector.onerror = function (error) {
        reject(error);
      };
      lector.readAsDataURL(archivo);
    });
  }

  const ruta_img_logo = "../dist/img/cpi_logo.png";

  const matCertifiedBtn = document.querySelectorAll('.cert-mat-btn')
  matCertifiedBtn.forEach((btn) => {
    btn.addEventListener('click', function () {
      let fullName = btn.dataset.student_full_name;
      let docType = btn.dataset.student_doc_type;
      let docNumb = btn.dataset.student_doc_numb;
      let docExpe = btn.dataset.student_doc_expe;
      let grado = btn.dataset.student_grado;


      // Define el contenido de la carta
      const content = [
        { text: 'LA SUSCRITA RECTORA DEL CENTRO PEDAGOGICO "LA INMACULADA"', style: 'header' },
        { text: '\n\nHACE CONSTAR\n\n', style: 'subheader' },
        {
          text: 'Que ROINER ISAI AZUAJE CORONADO Identificado con PERMISO POR PROTECCION TEMPORAL No 6751903 de Bogotá D. C, se encuentra matriculado en esta Institución en la Jornada Mañana, para cursar el Grado CUARTO (4°) de Educación Básica Primaria. Subsidiado en un 100% en el PROGRAMA DE BANCO DE OFERENTE.\n\n',
          style: 'body'
        },
        { text: 'Se expide la presente certificación, en Malambo a los 19 días del mes de Diciembre del 2023.\n\n', style: 'body' },
        { text: '\n\n_______________________________\nCARMEN ALICIA CASTRO PEREZ\nRectora', style: 'signature' }
      ];

      // Define los estilos
      const styles = {
        header: { fontSize: 14, bold: true, alignment: 'center', marginBottom: 10 },
        subheader: { fontSize: 12, bold: true, alignment: 'center', marginBottom: 10 },
        body: { fontSize: 12, alignment: 'justify', marginBottom: 10 },
        signature: { fontSize: 12, bold: true, alignment: 'center', marginTop: 20 }
      };

      // Define el documento
      const documentDefinition = {
        content,
        styles
      };

      // Genera el PDF y abre una nueva pestaña con el documento
      pdfMake.createPdf(documentDefinition).open();


    })
  })



});
