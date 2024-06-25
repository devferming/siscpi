document.addEventListener("DOMContentLoaded", function () {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 8000,
  });

  const currentFile = location.pathname.split("/").pop();

  if (currentFile == "matricula-nueva.php") {
    //Verifica que Num Doc alumno no exista en BD
    const docNumero = document.querySelector("#ide_num");
    docNumero.addEventListener("change", async (event) => {
      const dirModelo = document.querySelector(".form-customizado");
      const idUsuario = document.querySelector("#user-id").value;
      const modelo = dirModelo.dataset.modelo;
      const docNum = docNumero.value;

      const data = {
        cmd: "consultadocnumero",
        docnum: docNum,
        user_id: idUsuario,
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        const dataServer = await response.json();
        const btnForm = document.querySelector("#btn-submit");
        if (dataServer.respuesta === "error") {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
          btnForm.setAttribute("disabled", "true");
        } else {
          btnForm.removeAttribute("disabled");
        }
      } catch (error) {
        console.error(error);
      }
    });

    /*Controlador del input Fecha de Nacimiento*/
    const cumple = document.querySelector("#nac_fec");
    cumple.maxLength = 10;

    //Calcula la edad, y la asigna al input 'Edad' en el formulario
    cumple.addEventListener("change", (event) => {
      function calcularEdad(birthday) {
        let today = new Date();
        let birthDate = new Date(birthday);
        let age = today.getFullYear() - birthDate.getFullYear();
        let m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }
        return age;
      }

      let fechaString = event.target.value;
      let fechaPartes = fechaString.split("/");
      let dia = fechaPartes[0];
      let mes = fechaPartes[1];
      let anio = fechaPartes[2];
      let fechaNueva = anio + "/" + mes + "/" + dia;
      let dateString = fechaNueva;
      let edad = calcularEdad(dateString);

      const inputEdad = document.querySelector("#age_num");

      if (dia > 0 && dia <= 31) {
        if (mes > 0 && mes <= 12) {
          if (edad >= 2 && edad < 19) {
            inputEdad.value = edad;
            cumple.classList.remove("is-invalid");
            cumple.nextElementSibling.innerHTML = "Este campo es obligatorio.";
          } else if (edad < 2) {
            inputEdad.value = "";
            cumple.classList.add("is-invalid");
            cumple.nextElementSibling.innerHTML = "Fecha invalida (Menor de 2)";
          } else if (edad >= 19) {
            inputEdad.value = "";
            cumple.classList.add("is-invalid");
            cumple.nextElementSibling.innerHTML =
              "Fecha invalida (Mayor de 18)";
          }
        } else {
          cumple.classList.add("is-invalid");
          cumple.nextElementSibling.innerHTML = "Mes inválido";
        }
      } else {
        cumple.classList.add("is-invalid");
        cumple.nextElementSibling.innerHTML = "Día inválido";
      }
    });

    //Añade los separadores '/' automáticamente
    cumple.addEventListener("keydown", (event) => {
      if (event.keyCode !== 46 && event.keyCode !== 8) {
        let fecha = event.target.value;
        if (fecha.length === 2) {
          event.target.value = fecha + "/";
        }

        if (fecha.length === 5) {
          event.target.value = fecha + "/";
        }

        if (fecha.length > 10) {
          event.preventDefault();
        }
      }
    });

    //Convierte input en solo lectura
    const deSoloLectura = document.querySelectorAll(".soloLectura");
    deSoloLectura.forEach((input) => {
      input.readOnly = true;
    });

    //Establese lista de muncipios en el selec
    const inputDepartamento = document.querySelector("#nac_dep");
    const dirModelo = document.querySelector(".form-customizado");
    const modelo = dirModelo.dataset.modelo;
    let idUsuario = document.querySelector("#user-id").value;

    inputDepartamento.addEventListener("change", async (event) => {
      const departamento = event.target.value;
      const option = event.target.querySelector(
        `option[value='${departamento}']`
      );
      const departamentoIde = option.dataset.ide;

      const data = {
        cmd: "consultamunicipios",
        departamento: departamentoIde,
        user_id: idUsuario,
      };
      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        const dataServer = await response.json();
        const selectMunicipios = document.querySelector("#nac_mun");
        let options = "";
        dataServer.municipios.forEach((municipio) => {
          options += `<option value="${municipio.municipio}" data-ide="${municipio.id}">${municipio.municipio}</option>`;
        });
        selectMunicipios.innerHTML = options;
      } catch (error) {
        console.error(error);
      }
    });

    //Establece Nivel Sisben de acuerdo al Estrato seleccionado
    const inputEstrato = document.querySelector("#alu_est");

    const estratosSISBEN = {
      1: "4",
      2: "4",
      3: "3",
      4: "3",
      5: "2",
      6: "1",
    };

    inputEstrato.addEventListener("change", (event) => {
      const estrato = event.target.value;
      const inputNivel = document.querySelector("#sis_niv");
      inputNivel.value = estratosSISBEN[estrato];
    });

    //Mascaras de entrada para campos de formulario

    //Solo números
    document.querySelectorAll("input[data-tipo='solonumero']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[0-9. ]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    //Sólo letras
    document.querySelectorAll("input[data-tipo='solotexto']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ ]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });

      el.addEventListener("keyup", (event) => {
        event.target.value = event.target.value.toUpperCase();
      });
    });

    //Texto y números
    document
      .querySelectorAll("input[data-tipo='textoynumero']")
      .forEach((el) => {
        el.addEventListener("keypress", (event) => {
          const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 , . ]+$/;
          const key = event.key;
          if (!regex.test(key)) {
            event.preventDefault();
          }
        });

        el.addEventListener("keyup", (event) => {
          event.target.value = event.target.value.toUpperCase();
        });
      });

    //Fechas dd/mm/aaa
    document.querySelectorAll("input[data-tipo='fecha']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[0-9]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    //Dirección
    document.querySelectorAll("input[data-tipo='direccion']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 #-]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
      el.addEventListener("keyup", (event) => {
        event.target.value = event.target.value.toUpperCase();
      });
    });

    //Correo
    document.querySelectorAll("input[data-tipo='correo']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-Z0-9 @_.-]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    //Manejador de CheckBox
    document.querySelectorAll(".chkBox").forEach((el) => {
      el.addEventListener("change", function () {
        if (this.checked) {
          this.value = 1;
        } else {
          this.value = 0;
        }
      });
    });

    //Establece datos del acudiente automáticamente (Si el parentesco es padre o madre)
    const parentesco = document.querySelector("#acu_par");
    parentesco.addEventListener("change", (event) => {
      let paren = event.target.value;

      if (paren === "MADRE") {
        par = "mad";
      }

      if (paren === "PADRE") {
        par = "pad";
      }

      if (paren === "MADRE" || paren === "PADRE") {
        let documento = document.querySelector(`#${par}_doc`).value;
        let nombre = document.querySelector(`#${par}_nom`).value;
        let movil = document.querySelector(`#${par}_cel`).value;
        let ocupacion = document.querySelector(`#${par}_ocu`).value;
        let mail = document.querySelector(`#${par}_mai`).value;

        document.querySelector("#acu_doc").value = documento;
        document.querySelector("#acu_nom").value = nombre;
        document.querySelector("#acu_cel").value = movil;
        document.querySelector("#acu_ocu").value = ocupacion;
        document.querySelector("#acu_mai").value = mail;
      } else {
        document.querySelector("#acu_doc").value = "";
        document.querySelector("#acu_nom").value = "";
        document.querySelector("#acu_cel").value = "";
        document.querySelector("#acu_ocu").value = "";
        document.querySelector("#acu_mai").value = "";
      }
    });

    /*Validador de formulario*/

    const btnSubmitButton = document.querySelector("#btn-submit");
    btnSubmitButton.addEventListener("click", (event) => {
      let idUsuario = document.querySelector("#user-id").value;
      let idAlum = document.querySelector("#alum-id").value;
      let cmdForm = document.querySelector("#cmd").value;
      let alumGrd = document.querySelector("#gra_esc").value;

      let data = {
        cmd: cmdForm,
        user_id: idUsuario,
        alum_id: idAlum,
        alumGrd: alumGrd,
      };

      let inputs = document.querySelectorAll(".form-control");
      let estatusForm = 0;
      inputs.forEach((input) => {
        {
          input.required === true && input.value === ""
            ? (input.classList.add("is-invalid"),
              (estatusForm += 1),
              Toast.fire({
                icon: "error",
                title: "Complete los campos requeridos",
              }))
            : (input.classList.add("is-valid"),
              input.classList.remove("is-invalid"));
        }

        const { name, value } = input;
        const tipo = input.getAttribute("data-tipo");
        if (!data[name]) data[name] = {};
        data[name]["value"] = value;
        data[name]["tipo"] = tipo;
      });

      {
        estatusForm > 0 ? vigilaInputsObligatorios() : hacerSubmit(data);
      }
    });

    const vigilaInputsObligatorios = () => {
      let inputsObligatorios = document.querySelectorAll(".is-invalid");
      inputsObligatorios.forEach((input) => {
        input.addEventListener("change", (event) => {
          input.classList.remove("is-invalid");
          input.classList.add("is-valid");
        });
      });
    };

    const hacerSubmit = async (dataRecibida) => {
      const dirModelo = document.querySelector(".form-customizado");
      const modelo = dirModelo.dataset.modelo;

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(dataRecibida),
        });

        const dataServer = await response.json();

        if (dataServer.respuesta == "exito") {
          Swal.fire({
            title: dataServer.comentario,
            text: "¿Qué deseas hacer?",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Seguir Matriculando",
            confirmButtonText: "Imprimir Matrícula",
          }).then((result) => {
            if (result.isConfirmed) {
              let aluId = dataServer.idObtenido;
              let useId = dataServer.idUser;

              const consultaAlumno = async () => {
                try {
                  let data = {
                    cmd: "alumno-consulta",
                    id: aluId,
                    user_id: useId,
                  };
                  const response = await fetch(modelo, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data),
                  });
                  const dataServer = await response.json();
                  if (dataServer.respuesta === "exito") {
                    const datos = JSON.parse(dataServer.datos["datos"]);

                    const date = new Date();
                    const fechaActual = date.toLocaleDateString("es-ES", {
                      day: "2-digit",
                      month: "2-digit",
                      year: "numeric",
                    });
                    const horaActual = date.toLocaleTimeString("es-ES", {
                      hour: "2-digit",
                      minute: "2-digit",
                      hour12: true,
                    });

                    const fechaMat = `${fechaActual} ${horaActual}`;

                    /////////////////////////////////////////////////////////

                    const docDefinition = {
                      pageSize: { width: 612, height: 936 },
                      pageOrientation: "portrait",
                      pageMargins: [45, 60, 40, 60],
                      content: [
                        {
                          table: {
                            widths: [80, 70, 30, 30, 30, 30, 30, 65, 70],
                            body: [
                              [
                                {
                                  rowSpan: 5,
                                  image:
                                    "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAC0CAYAAAA9zQYyAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzlGRTk5NDE1NDE4MTFFRDhCODU4NEZDNzBEMDM2QTciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzlGRTk5NDI1NDE4MTFFRDhCODU4NEZDNzBEMDM2QTciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozOUZFOTkzRjU0MTgxMUVEOEI4NTg0RkM3MEQwMzZBNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozOUZFOTk0MDU0MTgxMUVEOEI4NTg0RkM3MEQwMzZBNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PkSHgC0AAPOCSURBVHja7L0HtF3X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",
                                  width: 80,
                                  height: 80,
                                },
                                {
                                  text: "HOJA DE MATRÍCULA AÑO LECTIVO 2023",
                                  style: "tableTitulo",
                                  colSpan: 8,
                                  alignment: "center",
                                  fontSize: 9,
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],
                              [
                                {},
                                {
                                  text: "DANE",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                  alignment: "center",
                                },
                                {
                                  text: "6565665656565656565",
                                  style: "tableTexto",
                                  colSpan: 5,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                                {
                                  rowSpan: 1,
                                  text: "FOLIO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                  alignment: "center",
                                  border: [true, true, true, false],
                                },
                                {
                                  rowSpan: 4,
                                  text: "FOTO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                  alignment: "center",
                                },
                              ],
                              [
                                {},
                                {
                                  text: "JORNADA",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                  alignment: "center",
                                },
                                {
                                  text: datos.gra_jor,
                                  style: "tableTexto",
                                  colSpan: 5,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                                {
                                  rowSpan: 3,
                                  text: datos.alu_fol,
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                  alignment: "center",
                                  border: [true, false, true, true],
                                  margin: [0, 12, 0, 0],
                                  fontSize: 10,
                                },
                                {},
                              ],
                              [
                                {},
                                {
                                  text: "GRADO A CURSAR AÑO 2023",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {
                                  text: datos.gra_esc,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                              ],
                              [
                                {},
                                {
                                  text: "FECHA DE MATRÍCULA",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                  alignment: "center",
                                  margin: [0, 5, 0, 0],
                                },
                                {},
                                {},
                                {
                                  text: datos.fec_mat,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                  margin: [0, 3, 0, 0],
                                },
                                {},
                                {},
                                {},
                                {},
                              ],
                              [
                                {
                                  text: "",
                                  style: "tableTexto",
                                  colSpan: 9,
                                  border: [false, false, false, false],
                                  margin: [0, 10, 0, 0],
                                },
                              ],
                            ],
                          },
                        },
                        {
                          table: {
                            widths: [
                              34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34,
                            ],
                            // headerRows: 3,
                            // keepWithHeaderRows: 1,
                            body: [
                              [
                                {
                                  text: "INFORMACIÓN DEL ALUMNO",
                                  style: "tableTitulo",
                                  colSpan: 12,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "IDENTIFICACIÓN",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: `(${datos.ide_tip}) - ${datos.ide_num}`,
                                  style: "tableTexto",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "LUGAR DE EXPEDICIÓN",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.ide_exp,
                                  style: "tableTexto",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "PRIMER APELLIDO",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "SEGUNDO APELLIDO",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "PRIMER NOMBRE",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "SEGUNDO NOMBRE",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                              ],

                              [
                                {
                                  text: datos.per_ape,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {
                                  text: datos.sdo_ape,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {
                                  text: datos.per_nom,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {
                                  text: datos.sdo_nom,
                                  style: "tableTexto",
                                  colSpan: 3,
                                  alignment: "center",
                                },
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "FECHA DE NACIMIENTO",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: datos.nac_fec,
                                  style: "tableTexto",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: "EDAD",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.age_num,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "GENERO",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.alu_gen,
                                  style: "tableTexto",
                                  colSpan: 2,
                                },
                                {},
                              ],

                              [
                                {
                                  text: "MUNICIPIO DE NACIMIENTO",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: datos.nac_mun,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "DEPARTAMENTO DE NACIMIENTO",
                                  style: "tableSubTitulo",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: datos.nac_dep,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "ESTRATO",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.alu_est,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "NIVEL SISBEN",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.sis_niv,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "GRUPO ETNICO",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.alu_get,
                                  style: "tableTexto",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "UBICACIÓN DEL ALUMNO",
                                  style: "tableTitulo",
                                  colSpan: 12,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "DIRECCIÓN",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.dir_dir,
                                  style: "tableTexto",
                                  colSpan: 5,
                                },
                                {},
                                {},
                                {},
                                {},
                                {
                                  text: "BARRIO",
                                  style: "tableSubTitulo",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: datos.dir_bar,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "LOCALIDAD",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.dir_loc,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "TELF EMER.",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.tel_mov,
                                  style: "tableTexto",
                                  colSpan: 2,
                                },
                                {},
                                {
                                  text: "E-MAIL",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.alu_mai,
                                  style: "tableTexto",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "HISTORIA ACADÉMICA",
                                  style: "tableTitulo",
                                  colSpan: 12,
                                  alignment: "center",
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "GRADO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: "AÑO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: "INSTITUCIÓN",
                                  style: "tableSubTitulo",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "GRADO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: "AÑO",
                                  style: "tableSubTitulo",
                                  colSpan: 1,
                                },
                                {
                                  text: "INSTITUCIÓN",
                                  style: "tableSubTitulo",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "PÁRV.",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n96_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n96_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "2DO",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n2_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n2_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "PREJ.",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n97_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n97_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "3RO",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n3_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n3_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "JARD.",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n98_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n98_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "4TO.",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n4_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n4_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "TRAN.",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n99_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n99_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {
                                  text: "5TO",
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n5_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n5_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "1RO",
                                  style: "tableTexto2",
                                },
                                {
                                  text: datos.n1_ani,
                                  style: "tableTexto2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.n1_nom,
                                  style: "tableTexto2",
                                  colSpan: 4,
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],
                            ],
                          },
                        },
                        {
                          table: {
                            widths: [45, 65, 5, 43, 5, 65, 5, 50, 55, 5, 60, 5],
                            // headerRows: 3,
                            // keepWithHeaderRows: 1,
                            body: [
                              [
                                {
                                  text: "LIMITACIONES O CAPACIDADES EXCEPCIONALES (ANEXAR SOPORTE MÉDICO - ESPECIALISTA)",
                                  style: "tableTitulo",
                                  colSpan: 12,
                                  alignment: "center",
                                  vAlign: "center",
                                  border: [true, false, true, true],
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "",
                                  style: "tableSubTitulo2",
                                  border: [true, true, true, false],
                                },
                                {
                                  text: "SINDROME DE DOWN",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_1 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "BAJA VISIÓN",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_4 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "PARÁLISIS CEREBRAL",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_7 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "",
                                  style: "tableSubTitulo2",
                                  border: [true, true, true, false],
                                },
                                {
                                  text: "SUPER DOTADO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.cap_1 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "TECNOLÓGICO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.cap_3 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "LIMITACIONES",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                  vAlign: "center",
                                  border: [true, false, true, false],
                                },
                                {
                                  text: "RETARDO MENTAL LEVE",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_2 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "CEGUERA",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_5 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "LESIÓN NEUROMUSCULAR",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_8 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "CAPACIDADES EXCEPCIONALES",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                  vAlign: "center",
                                  border: [true, false, true, false],
                                },
                                {
                                  text: "CIENTÍFICO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.cap_2 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "ARTISTICO SUBJETIVO DEPORTIVO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.cap_4 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "",
                                  style: "tableSubTitulo2",
                                  border: [true, false, true, true],
                                },
                                {
                                  text: "SORDERA",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                  height: 30,
                                },
                                {
                                  text: datos.lim_3 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "AUTISMO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_6 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "NINGUNA",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.lim_9 > 0 ? "x" : "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: "",
                                  style: "tableSubTitulo2",
                                  border: [true, false, true, true],
                                },
                                {
                                  text: "PUNTAJE IQ",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "1650",
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                              ],
                            ],
                          },
                        },
                        {
                          table: {
                            widths: [50, 150, 50, 50, 60, 102],
                            body: [
                              [
                                {
                                  text: "INFORMACIÓN DE LOS PADRES Y ACUDIENTES",
                                  style: "tableTitulo",
                                  colSpan: 6,
                                  alignment: "center",
                                  border: [true, false, true, true],
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "PARENTESCO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "NOMBRE Y APELLIDO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "N° DE DOCUMENTO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "CELULAR",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "OCUPACIÓN",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: "CORREO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "PADRE",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.pad_nom,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.pad_doc,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.pad_cel,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.pad_ocu,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.pad_mai,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],
                              [
                                {
                                  text: "MADRE",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.mad_nom,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.mad_doc,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.mad_cel,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.mad_ocu,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.mad_mai,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],
                              [
                                {
                                  text: "ACUDIENTE",
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.acu_nom,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.acu_doc,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.acu_cel,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.acu_ocu,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.acu_mai,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "INFORMACIÓN DE SALUD",
                                  style: "tableTitulo",
                                  colSpan: 6,
                                  alignment: "center",
                                  border: [true, false, true, true],
                                },
                                {},
                                {},
                                {},
                                {},
                                {},
                              ],

                              [
                                {
                                  text: "PROBLEMÁTICA DE SALUD PRESENTADA POR EL ESTUDIANTE",
                                  style: "tableSubTitulo2",
                                  colSpan: 6,
                                },
                              ],
                              [
                                {
                                  text: datos.sal_pro,
                                  style: "tableTexto",
                                  colSpan: 6,
                                },
                              ],

                              [
                                {
                                  text: "EPS",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.sal_eps,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "GRUPO SANGUINEO",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.sal_gsan,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "IPS",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.sal_ips,
                                  style: "tableTexto",
                                  colSpan: 3,
                                },
                                {},
                                {},
                                {
                                  text: "FACTOR RH",
                                  style: "tableSubTitulo2",
                                  colSpan: 1,
                                },
                                {
                                  text: datos.sal_frh,
                                  style: "tableTexto",
                                  colSpan: 1,
                                },
                              ],

                              [
                                {
                                  text: "",
                                  style: "tableTexto",
                                  colSpan: 6,
                                  border: [false, false, false, false],
                                  margin: [0, 10, 0, 0],
                                },
                              ],

                              [
                                {
                                  text: "ACEPTAMOS CUMPLIR CON EL PROYECTO EDUCATIVO INSTITUCIONAL (PEI) Y EL MANUAL DE CONVIVENCIA Y DEMÁS DISPOSICIONES",
                                  style: "tableTitulo",
                                  colSpan: 6,
                                },
                              ],
                            ],
                          },
                        },
                        {
                          table: {
                            widths: [94, 94, 94, 94, 94],
                            body: [
                              [
                                {
                                  text: "FIRMA DEL RECTOR",
                                  style: "tableTexto",
                                  colSpan: 2,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                },
                                {},
                                {
                                  text: "FIRMA DE LA DIRECTORA",
                                  style: "tableTexto",
                                  colSpan: 1,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                },
                                {
                                  text: "FIRMA DE LA SECRETARIA",
                                  style: "tableTexto",
                                  colSpan: 2,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                },
                                {},
                              ],

                              [
                                {
                                  text: "FIRMA DEL ALUMNO",
                                  style: "tableTexto",
                                  colSpan: 2,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                  alignment: "right",
                                },
                                {},
                                {
                                  text: "",
                                  style: "tableTexto",
                                  colSpan: 1,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                },
                                {
                                  text: "FIRMA DEL ACUDIENTE",
                                  style: "tableTexto",
                                  colSpan: 2,
                                  border: [false, false, false, false],
                                  margin: [0, 60, 0, 0],
                                  alignment: "left",
                                },
                                {},
                              ],
                            ],
                          },
                        },
                      ],
                      styles: {
                        header: {
                          fontSize: 18,
                          bold: true,
                          margin: [0, 0, 0, 10],
                        },
                        tableTitulo: {
                          bold: true,
                          fontSize: 7,
                          color: "black",
                          fillColor: "#CECECE",
                          margin: [0, 3, 0, 3],
                          alignment: "center",
                        },
                        tableSubTitulo: {
                          bold: true,
                          fontSize: 6,
                          color: "black",
                          fillColor: "#F2F2F2",
                          alignment: "center",
                        },
                        tableSubTitulo2: {
                          bold: true,
                          fontSize: 6,
                          color: "black",
                          fillColor: "#F2F2F2",
                          alignment: "center",
                        },
                        tableTexto: {
                          bold: false,
                          fontSize: 8,
                          color: "black",
                          alignment: "center",
                        },
                        tableTexto2: {
                          bold: false,
                          fontSize: 7,
                          color: "black",
                          alignment: "center",
                        },
                      },
                    };

                    pdfMake.createPdf(docDefinition).open();
                    ////////////////////////////////////////////////////////////
                  }

                  if (dataServer.respuesta === "error") {
                    console.log("error");
                  }
                } catch (error) {
                  console.error(error);
                }
              };

              consultaAlumno();
            } else {
              window.location.reload();
            }
          });
        } else {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
        }
      } catch (error) {
        console.error(error);
      }
    };
  }

  if (currentFile == "matricula-lotes.php") {
    //Manejador de CheckBox
    document.querySelectorAll(".chkBox").forEach((el) => {
      el.addEventListener("change", function () {
        if (this.checked) {
          this.value = 1;
        } else {
          this.value = 0;
        }
      });
    });

    //manejador del boton de submit Mat Lotes
    const btn = document.getElementById("matricularLoteBtn");
    btn.onclick = function () {
      userId = document.getElementById("userId").dataset.usid;
      let dataMad = {};
      let mat = 0;
      document.querySelectorAll(".chkBox").forEach((el) => {
        if (el.value == 1) {
          let id = el.dataset.idalum;
          dataMad[id] = "mat";
          mat = 1;
        }
      });

      if (mat > 0) {
        const matLotes = async () => {
          try {
            let data = {
              cmd: "mat-lotes",
              user_id: userId,
              dataMad: dataMad,
            };
            const response = await fetch("../modelos/matricula-modelo.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify(data),
            });
            const dataServer = await response.json();

            if (dataServer.respuesta === "exito") {
              Toast.fire({
                icon: "success",
                title: dataServer.comentario,
              });
              setTimeout(function () {
                location.reload();
              }, 3000);
            }

            if (dataServer.respuesta === "error") {
              Toast.fire({
                icon: "error",
                title: dataServer.comentario,
              });
            }
          } catch (error) {
            console.error(error);
          }
        };

        matLotes();
      }
    };
  }

  if (currentFile == "usuario-nuevo.php") {
    //Indica si hay check inputs habilitados o no

    let revisarChecks = 0;

    //Verifica que Num Doc alumno no exista en BD
    const docNumero = document.querySelector("#ide_num");
    docNumero.addEventListener("change", async (event) => {
      const dirModelo = document.querySelector(".form-customizado");
      const idUsuario = document.querySelector("#user-id").value;
      const modelo = dirModelo.dataset.modelo;
      const docNum = docNumero.value;

      const data = {
        cmd: "consultadocnumero",
        docnum: docNum,
        user_id: idUsuario,
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        const dataServer = await response.json();
        const btnForm = document.querySelector("#btn-submit");
        if (dataServer.respuesta === "error") {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
          btnForm.setAttribute("disabled", "true");
        } else {
          btnForm.removeAttribute("disabled");
        }
      } catch (error) {
        console.error(error);
      }
    });

    /*Controlador del input Fecha de Nacimiento*/
    const cumple = document.querySelector("#nac_fec");
    cumple.maxLength = 10;

    //Calcula la edad, y la asigna al input 'Edad' en el formulario
    cumple.addEventListener("change", (event) => {
      function calcularEdad(birthday) {
        let today = new Date();
        let birthDate = new Date(birthday);
        let age = today.getFullYear() - birthDate.getFullYear();
        let m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }
        return age;
      }

      let fechaString = event.target.value;
      let fechaPartes = fechaString.split("/");
      let dia = fechaPartes[0];
      let mes = fechaPartes[1];
      let anio = fechaPartes[2];
      let fechaNueva = anio + "/" + mes + "/" + dia;
      let dateString = fechaNueva;
      let edad = calcularEdad(dateString);
      const inputEdad = document.querySelector("#age_num");

      if (dia > 0 && dia <= 31) {
        if (mes > 0 && mes <= 12) {
          if (edad >= 18 && edad < 66) {
            inputEdad.value = edad;
            cumple.classList.remove("is-invalid");
            cumple.nextElementSibling.innerHTML = "Este campo es obligatorio.";
          } else if (edad < 18) {
            inputEdad.value = "";
            cumple.classList.add("is-invalid");
            cumple.nextElementSibling.innerHTML =
              "Fecha invalida (Menor de 18)";
          } else if (edad >= 66) {
            inputEdad.value = "";
            cumple.classList.add("is-invalid");
            cumple.nextElementSibling.innerHTML =
              "Fecha invalida (Mayor de 65)";
          }
        } else {
          cumple.classList.add("is-invalid");
          cumple.nextElementSibling.innerHTML = "Mes inválido";
        }
      } else {
        cumple.classList.add("is-invalid");
        cumple.nextElementSibling.innerHTML = "Día inválido";
      }
    });

    //Añade los separadores '/' automáticamente
    cumple.addEventListener("keydown", (event) => {
      if (event.keyCode !== 46 && event.keyCode !== 8) {
        let fecha = event.target.value;
        if (fecha.length === 2) {
          event.target.value = fecha + "/";
        }

        if (fecha.length === 5) {
          event.target.value = fecha + "/";
        }

        if (fecha.length > 10) {
          event.preventDefault();
        }
      }
    });

    //Convierte input en solo lectura
    const deSoloLectura = document.querySelectorAll(".soloLectura");
    deSoloLectura.forEach((input) => {
      input.readOnly = true;
    });

    //Establese lista de muncipios en el selec
    const inputDepartamento = document.querySelector("#nac_dep");
    const dirModelo = document.querySelector(".form-customizado");
    const modelo = dirModelo.dataset.modelo;
    let idUsuario = document.querySelector("#user-id").value;

    inputDepartamento.addEventListener("change", async (event) => {
      const departamento = event.target.value;
      const option = event.target.querySelector(
        `option[value='${departamento}']`
      );
      const departamentoIde = option.dataset.ide;

      const data = {
        cmd: "consultamunicipios",
        departamento: departamentoIde,
        user_id: idUsuario,
      };
      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        const dataServer = await response.json();
        const selectMunicipios = document.querySelector("#nac_mun");
        let options = "";
        dataServer.municipios.forEach((municipio) => {
          options += `<option value="${municipio.municipio}" data-ide="${municipio.id}">${municipio.municipio}</option>`;
        });
        selectMunicipios.innerHTML = options;
      } catch (error) {
        console.error(error);
      }
    });

    /*
     **Mascaras de entrada para campos de formulario
     */

    //Solo números
    document.querySelectorAll("input[data-tipo='solonumero']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[0-9. ]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    //Sólo letras
    document.querySelectorAll("input[data-tipo='solotexto']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ ]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });

      el.addEventListener("keyup", (event) => {
        event.target.value = event.target.value.toUpperCase();
      });
    });

    //Texto y números
    document
      .querySelectorAll("input[data-tipo='textoynumero']")
      .forEach((el) => {
        el.addEventListener("keypress", (event) => {
          const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 , . ]+$/;
          const key = event.key;
          if (!regex.test(key)) {
            event.preventDefault();
          }
        });

        el.addEventListener("keyup", (event) => {
          event.target.value = event.target.value.toUpperCase();
        });
      });

    //Fechas dd/mm/aaa
    document.querySelectorAll("input[data-tipo='fecha']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[0-9]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    //Dirección
    document.querySelectorAll("input[data-tipo='direccion']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 #-]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
      el.addEventListener("keyup", (event) => {
        event.target.value = event.target.value.toUpperCase();
      });
    });

    //Correo
    document.querySelectorAll("input[data-tipo='correo']").forEach((el) => {
      el.addEventListener("keypress", (event) => {
        const regex = /^[a-zA-Z0-9 @_.-]+$/;
        const key = event.key;
        if (!regex.test(key)) {
          event.preventDefault();
        }
      });
    });

    /*
     **Validador de formulario
     */

    const btnSubmitButton = document.querySelector("#btn-submit");
    btnSubmitButton.addEventListener("click", (event) => {
      let idUsuario = document.querySelector("#user-id").value;
      let cmdForm = document.querySelector("#cmd").value;

      let data = {
        cmd: cmdForm,
        user_id: idUsuario,
      };

      let inputs = document.querySelectorAll(
        ".form-control, .form-check-input"
      );
      
      let estatusForm = 0;

      inputs.forEach((input) => {
        {
          input.required === true && input.value === ""
            ? (input.classList.add("is-invalid"),
              (estatusForm += 1),
              Toast.fire({
                icon: "error",
                title: "Complete los campos requeridos",
              }))
            : (input.classList.add("is-valid"),
              input.classList.remove("is-invalid"));
        }

        const { name, value, multiple } = input;
        const tipo = input.getAttribute("data-tipo");
        if (multiple) {
          const selectedOptions = Array.from(input.selectedOptions).map(
            (option) => option.value
          );

          if (!data[name]) data[name] = {};
          data[name]["value"] = selectedOptions;
          data[name]["tipo"] = tipo;
        } else {
          if (!data[name]) data[name] = {};
          data[name]["value"] = value;
          data[name]["tipo"] = tipo;
        }
      });

      {
        estatusForm > 0 ? vigilaInputsObligatorios() : hacerSubmit(data);
      }
    });

    const vigilaInputsObligatorios = () => {
      let inputsObligatorios = document.querySelectorAll(".is-invalid");
      inputsObligatorios.forEach((input) => {
        input.addEventListener("change", (event) => {
          input.classList.remove("is-invalid");
          input.classList.add("is-valid");
        });
      });
    };

    const hacerSubmit = async (dataRecibida) => {
      const dirModelo = document.querySelector(".form-customizado");
      const modelo = dirModelo.dataset.modelo;

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(dataRecibida),
        });

        const dataServer = await response.json();

        if (dataServer.respuesta == "exito") {
          Toast.fire({
            icon: "success",
            title: dataServer.comentario,
          });
          setTimeout(function () {
            window.location.reload();
          }, 2000);
        } else {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
        }
      } catch (error) {
        console.error(error);
      }
    };

  }

  if (
    currentFile == "notas-fortalezados.php" ||
    currentFile == "monitor-fortalezados.php"
  ) {
    /*
     **Mascaras de entrada para campos de Fortalezados
     */

    //Texto y números
    document
      .querySelectorAll("textarea[data-tipo='textofortalezado']")
      .forEach((el) => {
        el.addEventListener("keypress", (event) => {
          const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 , . # ( ) -]+$/;
          const key = event.key;
          if (!regex.test(key)) {
            event.preventDefault();
          }
        });
      });

    /*
     ** Maneja los inputs de modulo de fortalezados
     */

    let inputs = document.querySelectorAll(".customclv");
    inputs.forEach((input) => {
      const textInput = document.querySelector(`#${input.id}`);

      textInput.addEventListener("change", (event) => {
        const textClt = JSON.parse(event.target.getAttribute("data-info"));
        guardarFortalezado(textClt, event.target.value);
      });
    });

    const nvlMap = {
      1: "n1",
      2: "n2",
      3: "n3",
    };

    async function guardarFortalezado(info, text) {
      let nvl = nvlMap[info.niv] || "";

      const data = {
        cmd: "ftznuevo",
        mat: info.mat,
        gra: info.gra,
        per: info.per,
        ren: info.ren,
        niv: nvl,
        tip: info.tip,
        des: text,
        user_id: logId,
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });

        const dataServer = await response.json();
        if (dataServer.respuesta === "exito") {
          Toast.fire({
            icon: "success",
            title: dataServer.comentario,
          });
        } else {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
        }
      } catch (error) {
        console.error(error);
      }
    }
  }

  if (
    currentFile == "admin-aprendizajes.php" ||
    currentFile == "admin-mayacurricular.php"
  ) {
    /*
     **Mascaras de entrada para campos de Aprendizajes
     */

    //Texto y números
    document
      .querySelectorAll("textarea[data-tipo='textoaprendizaje']")
      .forEach((el) => {
        el.addEventListener("keypress", (event) => {
          const regex = /^[a-zA-ZÑñáéíóúüÁÉÍÓÚÜ0-9 , . # ( ) -]+$/;
          const key = event.key;
          if (!regex.test(key)) {
            event.preventDefault();
          }
        });
      });

    /*
     ** Maneja el input del Aprendizaje
     */

    let inputs = document.querySelectorAll(".customape");

    inputs.forEach((input) => {
      const textInput = document.querySelector(`#${input.id}`);
      textInput.addEventListener("change", (event) => {
        const mat = event.target.getAttribute("data-mat")
        const per = event.target.getAttribute("data-per")
        const gra = event.target.getAttribute("data-gra")
        const apo = event.target.getAttribute("data-apo")
        const ape = event.target.getAttribute("data-ape")
        const des = event.target.value
        const dat = [mat, per, gra, apo, ape, des]
        guardarAprendizaje(dat);
      });
    });


    async function guardarAprendizaje(dat) {

      const [mat, per, gra, apo, ape, des] = dat
      const data = {
        cmd: "apenuevo",
        mat: mat,
        per: per,
        gra: gra,
        apo: apo,
        ape: ape,
        des: des,
        user_id: logId,
      };

      try {

        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });

        const dataServer = await response.json();

        if (dataServer.respuesta === "exito") {
          Toast.fire({
            icon: "success",
            title: dataServer.comentario,
          });
        } else {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
        }

      } catch (error) {
        console.error(error);
      }

    }

    /*
     ** Maneja los inputs de Componente y Competencia
     */

    let othersinputs = document.querySelectorAll(".other-inputs");

    othersinputs.forEach((input) => {
      const textInput = document.querySelector(`#${input.id}`);
      textInput.addEventListener("change", (event) => {
        const mat = event.target.getAttribute("data-mat")
        const per = event.target.getAttribute("data-per")
        const gra = event.target.getAttribute("data-gra")
        const apn = event.target.getAttribute("data-apn")
        const clv = event.target.getAttribute("data-clv")
        const des = event.target.value
        const dat = [mat, per, gra, apn, clv, des]
        guardarComponente(dat);
      });
    });


    async function guardarComponente(dat) {

      const [mat, per, gra, apn, clv, des] = dat
      const data = {
        cmd: "cmpnuevo",
        mat: mat,
        per: per,
        gra: gra,
        apn: apn,
        clv: clv,
        des: des,
        user_id: logId,
      };

      try {

        const response = await fetch(modelo, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });

        const dataServer = await response.json();

        if (dataServer.respuesta === "exito") {
          Toast.fire({
            icon: "success",
            title: dataServer.comentario,
          });

        } else {
          Toast.fire({
            icon: "error",
            title: dataServer.comentario,
          });
        }

      } catch (error) {
        console.error(error);
      }

    }


  }
});
