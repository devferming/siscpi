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

  const ruta_img_logo = "dist/img/cpi_logo.png";

  const materiasDesc = {
    SOCIALES: {
      nombMateria: "CIENCIAS SOCIALES",
      ordMat: 1,
      matDesc:
        "CIENCIAS SOCIALES, HISTORIA, GEOGRAFIA, CONSTITUCION POLITICA Y DEMOCRACIA",
    },
    ESPAÑOL: {
      nombMateria: "HUMANIDADES Y LENGUA CASTELLANA",
      ordMat: 2,
      matDesc: "HUMANIDADES, LENGUA CASTELLANA E IDIOMAS EXTRANJEROS",
    },
    INGLÉS: {
      nombMateria: "INGLÉS",
      ordMat: 3,
      matDesc: "",
    },
    /*     LECTORES: {
          nombMateria: "LECTORES COMPETENTES",
          ordMat: 4,
          matDesc: "",
        }, */
    MATEMÁTICAS: {
      nombMateria: "MATEMÁTICAS, GEOMETRÍA, ESTADÍSTICA",
      ordMat: 5,
      matDesc: "MATEMÁTICAS",
    },
    NATURALES: {
      nombMateria: "BIOLOGÍA, QUÍMICA, FÍSICA",
      ordMat: 6,
      matDesc: "CIENCIAS NATURALES Y EDUCACION AMBIENTAL",
    },
    "ÉTICA Y RELIGIÓN": {
      nombMateria: "ÉTICA Y RELIGIÓN",
      ordMat: 7,
      matDesc: "EDUCACION ARTISTICA Y CULTURAL",
    },
    ARTÍSTICA: {
      nombMateria: "ARTE",
      ordMat: 8,
      matDesc: "",
    },
    MÚSICA: {
      nombMateria: "MÚSICA",
      ordMat: 9,
      matDesc: "",
    },
    DEPORTE: {
      nombMateria: "EDUCACIÓN FÍSICA",
      ordMat: 10,
      matDesc: "EDUCACION FISICA RECREACION Y DEPORTES",
    },
    INFORMÁTICA: {
      nombMateria: " INFORMÁTICA - TECNOLOGÍA",
      ordMat: 11,
      matDesc: "TECNOLOGIA E INFORMÁTICA",
    },
  };

  const materiasTra = {
    PESP: {
      nombMateria: "PESP",
      ordMat: 1,
      matDesc: "",
      matRut: 'dist/img/img-tra-1.png'
    },
    INGLÉS: {
      nombMateria: "INGLÉS",
      ordMat: 2,
      matDesc: "",
      matRut: 'dist/img/img-tra-2.png'
    },
    MATEMÁTICAS: {
      nombMateria: "MATEMÁTICAS",
      ordMat: 3,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-3.png'
    },
    GLOBALIZACIÓN: {
      nombMateria: "GLOBALIZACIÓN",
      ordMat: 4,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-4.png'
    },
    ARTÍSTICA: {
      nombMateria: "ARTE",
      ordMat: 5,
      matDesc: "",
      matRut: 'dist/img/img-tra-5.png'
    },
    CORPORAL: {
      nombMateria: "CORPORAL",
      ordMat: 6,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-6.png'
    },
    MÚSICA: {
      nombMateria: "MÚSICA",
      ordMat: 7,
      matDesc: "MÚSICA",
      matRut: 'dist/img/img-tra-8.png'
    },
  };

  const materiasJar = {
    PESP: {
      nombMateria: "PESP",
      ordMat: 1,
      matDesc: "",
      matRut: 'dist/img/img-tra-1.png'
    },
    INGLÉS: {
      nombMateria: "INGLÉS",
      ordMat: 2,
      matDesc: "",
      matRut: 'dist/img/img-tra-2.png'
    },
    MATEMÁTICAS: {
      nombMateria: "MATEMÁTICAS",
      ordMat: 3,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-3.png'
    },
    GLOBALIZACIÓN: {
      nombMateria: "GLOBALIZACIÓN",
      ordMat: 4,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-4.png'
    },
    ARTÍSTICA: {
      nombMateria: "ARTE",
      ordMat: 5,
      matDesc: "",
      matRut: 'dist/img/img-tra-5.png'
    },
    CORPORAL: {
      nombMateria: "CORPORAL",
      ordMat: 6,
      matDesc: "MATEMÁTICAS",
      matRut: 'dist/img/img-tra-6.png'
    }
  };

  const rendimientos = {
    TRA: {
      0: ["BAJO", "badgeBajo", 3],
      "0.0": ["BAJO", "badgeBajo", 3],
      0.1: ["BAJO", "badgeBajo", 3],
      0.2: ["BAJO", "badgeBajo", 3],
      0.3: ["BAJO", "badgeBajo", 3],
      0.4: ["BAJO", "badgeBajo", 3],
      0.5: ["BAJO", "badgeBajo", 3],
      0.6: ["BAJO", "badgeBajo", 3],
      0.7: ["BAJO", "badgeBajo", 3],
      0.8: ["BAJO", "badgeBajo", 3],
      0.9: ["BAJO", "badgeBajo", 3],
      "1.0": ["BAJO", "badgeBajo", 3],
      1: ["BAJO", "badgeBajo", 3],
      1.1: ["BAJO", "badgeBajo", 3],
      1.2: ["BAJO", "badgeBajo", 3],
      1.3: ["BAJO", "badgeBajo", 3],
      1.4: ["BAJO", "badgeBajo", 3],
      1.5: ["BAJO", "badgeBajo", 3],
      1.6: ["BAJO", "badgeBajo", 3],
      1.7: ["BAJO", "badgeBajo", 3],
      1.8: ["BAJO", "badgeBajo", 3],
      1.9: ["BAJO", "badgeBajo", 3],
      "2.0": ["BAJO", "badgeBajo", 3],
      2: ["BAJO", "badgeBajo", 3],
      2.1: ["BAJO", "badgeBajo", 3],
      2.2: ["BAJO", "badgeBajo", 3],
      2.3: ["BAJO", "badgeBajo", 3],
      2.4: ["BAJO", "badgeBajo", 3],
      2.5: ["BAJO", "badgeBajo", 3],
      2.6: ["BAJO", "badgeBajo", 3],
      2.7: ["BAJO", "badgeBajo", 3],
      2.8: ["BAJO", "badgeBajo", 2],
      2.9: ["BAJO", "badgeBajo", 2],
      "3.0": ["BAJO", "badgeBajo", 1],
      3: ["BAJO", "badgeBajo", 1],
      3.1: ["BAJO", "badgeBajo", 1],
      3.2: ["BÁSICO", "badgeBasico", 3],
      3.3: ["BÁSICO", "badgeBasico", 3],
      3.4: ["BÁSICO", "badgeBasico", 3],
      3.5: ["BÁSICO", "badgeBasico", 2],
      3.6: ["BÁSICO", "badgeBasico", 2],
      3.7: ["BÁSICO", "badgeBasico", 2],
      3.8: ["BÁSICO", "badgeBasico", 1],
      3.9: ["BÁSICO", "badgeBasico", 1],
      "4.0": ["ALTO", "badgeAlto", 3],
      4: ["ALTO", "badgeAlto", 3],
      4.1: ["ALTO", "badgeAlto", 3],
      4.2: ["ALTO", "badgeAlto", 3],
      4.3: ["ALTO", "badgeAlto", 2],
      4.4: ["ALTO", "badgeAlto", 2],
      4.5: ["ALTO", "badgeAlto", 1],
      4.6: ["SUPERIOR", "badgeSuperior", 3],
      4.7: ["SUPERIOR", "badgeSuperior", 3],
      4.8: ["SUPERIOR", "badgeSuperior", 2],
      4.9: ["SUPERIOR", "badgeSuperior", 2],
      "5.0": ["SUPERIOR", "badgeSuperior", 1],
      5: ["SUPERIOR", "badgeSuperior", 1],
    },
    PRI: {
      0: ["BAJO", "badgeBajo", 3],
      "0.0": ["BAJO", "badgeBajo", 3],
      0.1: ["BAJO", "badgeBajo", 3],
      0.2: ["BAJO", "badgeBajo", 3],
      0.3: ["BAJO", "badgeBajo", 3],
      0.4: ["BAJO", "badgeBajo", 3],
      0.5: ["BAJO", "badgeBajo", 3],
      0.6: ["BAJO", "badgeBajo", 3],
      0.7: ["BAJO", "badgeBajo", 3],
      0.8: ["BAJO", "badgeBajo", 3],
      0.9: ["BAJO", "badgeBajo", 3],
      "1.0": ["BAJO", "badgeBajo", 3],
      1: ["BAJO", "badgeBajo", 3],
      1.1: ["BAJO", "badgeBajo", 3],
      1.2: ["BAJO", "badgeBajo", 3],
      1.3: ["BAJO", "badgeBajo", 3],
      1.4: ["BAJO", "badgeBajo", 3],
      1.5: ["BAJO", "badgeBajo", 3],
      1.6: ["BAJO", "badgeBajo", 3],
      1.7: ["BAJO", "badgeBajo", 3],
      1.8: ["BAJO", "badgeBajo", 3],
      1.9: ["BAJO", "badgeBajo", 3],
      "2.0": ["BAJO", "badgeBajo", 3],
      2: ["BAJO", "badgeBajo", 3],
      2.1: ["BAJO", "badgeBajo", 3],
      2.2: ["BAJO", "badgeBajo", 3],
      2.3: ["BAJO", "badgeBajo", 3],
      2.4: ["BAJO", "badgeBajo", 3],
      2.5: ["BAJO", "badgeBajo", 3],
      2.6: ["BAJO", "badgeBajo", 3],
      2.7: ["BAJO", "badgeBajo", 3],
      2.8: ["BAJO", "badgeBajo", 2],
      2.9: ["BAJO", "badgeBajo", 2],
      "3.0": ["BAJO", "badgeBajo", 1],
      3: ["BAJO", "badgeBajo", 1],
      3.1: ["BAJO", "badgeBajo", 1],
      3.2: ["BÁSICO", "badgeBasico", 3],
      3.3: ["BÁSICO", "badgeBasico", 3],
      3.4: ["BÁSICO", "badgeBasico", 3],
      3.5: ["BÁSICO", "badgeBasico", 2],
      3.6: ["BÁSICO", "badgeBasico", 2],
      3.7: ["BÁSICO", "badgeBasico", 2],
      3.8: ["BÁSICO", "badgeBasico", 1],
      3.9: ["BÁSICO", "badgeBasico", 1],
      "4.0": ["ALTO", "badgeAlto", 3],
      4: ["ALTO", "badgeAlto", 3],
      4.1: ["ALTO", "badgeAlto", 3],
      4.2: ["ALTO", "badgeAlto", 3],
      4.3: ["ALTO", "badgeAlto", 2],
      4.4: ["ALTO", "badgeAlto", 2],
      4.5: ["ALTO", "badgeAlto", 1],
      4.6: ["SUPERIOR", "badgeSuperior", 3],
      4.7: ["SUPERIOR", "badgeSuperior", 3],
      4.8: ["SUPERIOR", "badgeSuperior", 2],
      4.9: ["SUPERIOR", "badgeSuperior", 2],
      "5.0": ["SUPERIOR", "badgeSuperior", 1],
      5: ["SUPERIOR", "badgeSuperior", 1],
    },
    SEC: {
      0: ["BAJO", "badgeBajo", 3],
      "0.0": ["BAJO", "badgeBajo", 3],
      0.1: ["BAJO", "badgeBajo", 3],
      0.2: ["BAJO", "badgeBajo", 3],
      0.3: ["BAJO", "badgeBajo", 3],
      0.4: ["BAJO", "badgeBajo", 3],
      0.5: ["BAJO", "badgeBajo", 3],
      0.6: ["BAJO", "badgeBajo", 3],
      0.7: ["BAJO", "badgeBajo", 3],
      0.8: ["BAJO", "badgeBajo", 3],
      0.9: ["BAJO", "badgeBajo", 3],
      "1.0": ["BAJO", "badgeBajo", 3],
      1: ["BAJO", "badgeBajo", 3],
      1.1: ["BAJO", "badgeBajo", 3],
      1.2: ["BAJO", "badgeBajo", 3],
      1.3: ["BAJO", "badgeBajo", 3],
      1.4: ["BAJO", "badgeBajo", 3],
      1.5: ["BAJO", "badgeBajo", 3],
      1.6: ["BAJO", "badgeBajo", 3],
      1.7: ["BAJO", "badgeBajo", 3],
      1.8: ["BAJO", "badgeBajo", 3],
      1.9: ["BAJO", "badgeBajo", 3],
      "2.0": ["BAJO", "badgeBajo", 3],
      2: ["BAJO", "badgeBajo", 3],
      2.1: ["BAJO", "badgeBajo", 3],
      2.2: ["BAJO", "badgeBajo", 3],
      2.3: ["BAJO", "badgeBajo", 3],
      2.4: ["BAJO", "badgeBajo", 3],
      2.5: ["BAJO", "badgeBajo", 3],
      2.6: ["BAJO", "badgeBajo", 3],
      2.7: ["BAJO", "badgeBajo", 3],
      2.8: ["BAJO", "badgeBajo", 3],
      2.9: ["BAJO", "badgeBajo", 2],
      "3.0": ["BAJO", "badgeBajo", 2],
      3: ["BAJO", "badgeBajo", 2],
      3.1: ["BAJO", "badgeBajo", 2],
      3.2: ["BAJO", "badgeBajo", 1],
      3.3: ["BAJO", "badgeBajo", 1],
      3.4: ["BÁSICO", "badgeBasico", 3],
      3.5: ["BÁSICO", "badgeBasico", 3],
      3.6: ["BÁSICO", "badgeBasico", 2],
      3.7: ["BÁSICO", "badgeBasico", 2],
      3.8: ["BÁSICO", "badgeBasico", 1],
      3.9: ["BÁSICO", "badgeBasico", 1],
      "4.0": ["BÁSICO", "badgeBasico", 1],
      4: ["BÁSICO", "badgeBasico", 1],
      4.1: ["ALTO", "badgeAlto", 3],
      4.2: ["ALTO", "badgeAlto", 3],
      4.3: ["ALTO", "badgeAlto", 2],
      4.4: ["ALTO", "badgeAlto", 2],
      4.5: ["ALTO", "badgeAlto", 1],
      4.6: ["SUPERIOR", "badgeSuperior", 3],
      4.7: ["SUPERIOR", "badgeSuperior", 3],
      4.8: ["SUPERIOR", "badgeSuperior", 2],
      4.9: ["SUPERIOR", "badgeSuperior", 2],
      "5.0": ["SUPERIOR", "badgeSuperior", 1],
      5: ["SUPERIOR", "badgeSuperior", 1],
    },
    BAC: {
      0: ["BAJO", "badgeBajo", 3],
      "0.0": ["BAJO", "badgeBajo", 3],
      0.1: ["BAJO", "badgeBajo", 3],
      0.2: ["BAJO", "badgeBajo", 3],
      0.3: ["BAJO", "badgeBajo", 3],
      0.4: ["BAJO", "badgeBajo", 3],
      0.5: ["BAJO", "badgeBajo", 3],
      0.6: ["BAJO", "badgeBajo", 3],
      0.7: ["BAJO", "badgeBajo", 3],
      0.8: ["BAJO", "badgeBajo", 3],
      0.9: ["BAJO", "badgeBajo", 3],
      "1.0": ["BAJO", "badgeBajo", 3],
      1: ["BAJO", "badgeBajo", 3],
      1.1: ["BAJO", "badgeBajo", 3],
      1.2: ["BAJO", "badgeBajo", 3],
      1.3: ["BAJO", "badgeBajo", 3],
      1.4: ["BAJO", "badgeBajo", 3],
      1.5: ["BAJO", "badgeBajo", 3],
      1.6: ["BAJO", "badgeBajo", 3],
      1.7: ["BAJO", "badgeBajo", 3],
      1.8: ["BAJO", "badgeBajo", 3],
      1.9: ["BAJO", "badgeBajo", 3],
      "2.0": ["BAJO", "badgeBajo", 3],
      2: ["BAJO", "badgeBajo", 3],
      2.1: ["BAJO", "badgeBajo", 3],
      2.2: ["BAJO", "badgeBajo", 3],
      2.3: ["BAJO", "badgeBajo", 3],
      2.4: ["BAJO", "badgeBajo", 3],
      2.5: ["BAJO", "badgeBajo", 3],
      2.6: ["BAJO", "badgeBajo", 3],
      2.7: ["BAJO", "badgeBajo", 3],
      2.8: ["BAJO", "badgeBajo", 3],
      2.9: ["BAJO", "badgeBajo", 3],
      "3.0": ["BAJO", "badgeBajo", 3],
      3: ["BAJO", "badgeBajo", 3],
      3.1: ["BAJO", "badgeBajo", 2],
      3.2: ["BAJO", "badgeBajo", 2],
      3.3: ["BAJO", "badgeBajo", 2],
      3.4: ["BAJO", "badgeBajo", 2],
      3.5: ["BAJO", "badgeBajo", 1],
      3.6: ["BAJO", "badgeBajo", 1],
      3.7: ["BAJO", "badgeBajo", 1],
      3.8: ["BÁSICO", "badgeBasico", 3],
      3.9: ["BÁSICO", "badgeBasico", 2],
      "4.0": ["BÁSICO", "badgeBasico", 1],
      4: ["BÁSICO", "badgeBasico", 1],
      4.1: ["ALTO", "badgeAlto", 3],
      4.2: ["ALTO", "badgeAlto", 3],
      4.3: ["ALTO", "badgeAlto", 2],
      4.4: ["ALTO", "badgeAlto", 2],
      4.5: ["ALTO", "badgeAlto", 1],
      4.6: ["SUPERIOR", "badgeSuperior", 3],
      4.7: ["SUPERIOR", "badgeSuperior", 3],
      4.8: ["SUPERIOR", "badgeSuperior", 2],
      4.9: ["SUPERIOR", "badgeSuperior", 2],
      "5.0": ["SUPERIOR", "badgeSuperior", 1],
      5: ["SUPERIOR", "badgeSuperior", 1],
    },
  };

  const gradosDesc = {
    1: [
      { grado: "PRIMERO", nivel: "PRI", logros: "mat_logros_pri_p", firma_ruta: "dist/img/firma1.png" }
    ],
    2: [
      { grado: "SEGUNDO", nivel: "PRI", logros: "mat_logros_pri_p", firma_ruta: "dist/img/firma2.png" }
    ],
    3: [
      { grado: "TERCERO", nivel: "PRI", logros: "mat_logros_pri_p", firma_ruta: "dist/img/firma3.png" }
    ],
    4: [
      { grado: "CUARTO", nivel: "PRI", logros: "mat_logros_pri_p", firma_ruta: "dist/img/firma4.png" }
    ],
    5: [
      { grado: "QUINTO", nivel: "PRI", logros: "mat_logros_pri_p", firma_ruta: "dist/img/firma5.png" }
    ],
    6: [
      { grado: "SEXTO", nivel: "SEC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma6.png" }
    ],
    7: [
      { grado: "SÉPTIMO", nivel: "SEC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma7.png" }
    ],
    8: [
      { grado: "OCTAVO", nivel: "SEC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma8A.png" },
      { grado: "OCTAVO", nivel: "SEC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma8B.png" }
    ],
    9: [
      { grado: "NOVENO", nivel: "BAC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma9.png" }
    ],
    10: [
      { grado: "DÉCIMO", nivel: "BAC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma10A.png" },
      { grado: "DÉCIMO", nivel: "BAC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma10B.png" }
    ],
    11: [
      { grado: "UNDÉCIMO", nivel: "BAC", logros: "mat_logros_sec_p", firma_ruta: "dist/img/firma11.png" }
    ],
    12: [
      { grado: "PRE JARDÍN", nivel: "TRA", logros: "mat_logros_tra_p", firma_ruta: "dist/img/firma13.png" }
    ],
    13: [
      { grado: "JARDÍN", nivel: "TRA", logros: "mat_logros_tra_p", firma_ruta: "dist/img/firma13.png" }
    ],
    14: [
      { grado: "TRANSICIÓN", nivel: "TRA", logros: "mat_logros_tra_p", firma_ruta: "dist/img/firma12.png" },
      { grado: "TRANSICIÓN", nivel: "TRA", logros: "mat_logros_tra_p", firma_ruta: "dist/img/firma12.png" }
    ]
  };

  const periodos = {
    1: "PRIMERO",
    2: "SEGUNDO",
    3: "TERCERO",
    4: "CUARTO",
  };

  (async () => {
    try {
      const response = await fetch(ruta_img_logo);
      const blob = await response.blob();
      const img_logo_base64 = await convertirImagenABase64(blob);
      const img_logo = img_logo_base64;

      document.querySelectorAll(".btn-bol-pdf").forEach((el) => {
        el.addEventListener("click", function () {
          /////////////////////////////////////////////////////////
          // let aluId = el.value;
          let useId = el.dataset.uid;
          let periodo = el.dataset.per;
          let gradoNum = el.dataset.gra;
          let gradoSec = el.dataset.sec;
          let firmaRuta = '';

          if (gradoNum in gradosDesc) {
            alumSector = gradosDesc[gradoNum][0].nivel;
            descGrado = gradosDesc[gradoNum][0].grado;

            if (gradoSec === 'U' || gradoSec === 'A') {
              firmaRuta = gradosDesc[gradoNum][0].firma_ruta;
            } else {
              firmaRuta = gradosDesc[gradoNum][1].firma_ruta;
            }

          }

          if (periodo in periodos) {
            per = periodos[periodo];
          }

          const consultaAlumnos = async () => {
            try {
              let data = {
                cmd: "boletines-consulta",
                gra: descGrado,
                sec: gradoSec,
                per: periodo,
                user_id: useId,
              };
              const response = await fetch("modelos/boletines-modelo.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
              });

              const dataServer = await response.json();

              if (dataServer.respuesta === "exito") {

                const datAlumnos = JSON.parse(dataServer.alumnos);

                const docDefinition = {
                  pageSize: { width: 595.276, height: 841.89 },
                  pageOrientation: "portrait",
                  pageMargins: [30, 20, 30, 10],
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
                    textoFtz: {
                      bold: false,
                      fontSize: 7,
                      color: "black",
                      alignment: "center",
                    },
                    tableTexto2: {
                      bold: false,
                      fontSize: 7,
                      color: "black",
                      alignment: "center",
                    },
                    badgeBajo: {
                      background: "#DC3545", // Color de fondo del badge
                      color: "white", // Color del texto del badge
                      padding: [4, 8], // Ajuste del padding
                      border: [1, 1, 1, 1], // Borde del badge
                      borderRadius: 10, // Radio del borde
                      fontSize: 6,
                      bold: true,
                    },
                    badgeBasico: {
                      background: "#FFC107", // Color de fondo del badge
                      color: "black", // Color del texto del badge
                      padding: [4, 8], // Ajuste del padding
                      border: [1, 1, 1, 1], // Borde del badge
                      borderRadius: 10, // Radio del borde
                      fontSize: 6,
                      bold: true,
                    },
                    badgeAlto: {
                      background: "#28A745", // Color de fondo del badge
                      color: "white", // Color del texto del badge
                      padding: [4, 8], // Ajuste del padding
                      border: [1, 1, 1, 1], // Borde del badge
                      borderRadius: 10, // Radio del borde
                      fontSize: 6,
                      bold: true,
                    },
                    badgeSuperior: {
                      background: "#343A40", // Color de fondo del badge
                      color: "white", // Color del texto del badge
                      padding: [4, 8], // Ajuste del padding
                      border: [1, 1, 1, 1], // Borde del badge
                      borderRadius: 10, // Radio del borde
                      fontSize: 6,
                      bold: true,
                    },
                  },
                  content: [],
                };


                for (const aluId in datAlumnos) {
                  if (datAlumnos.hasOwnProperty(aluId)) {

                    let matEv;
                    let matPer = 0;
                    let matPro = 0;

                    const alumno = datAlumnos[aluId];
                    const alum_dat = alumno.datos;
                    const alum_not = alumno.notas['p-' + periodo];

                    let datMat = alum_dat;
                    //let datNot = datos[aluId].not ? JSON.parse(datos[aluId].not) : [];

                    let datNot;

                    if (Object.keys(alum_not).length === 0) {
                      datNot = [];
                    } else {
                      datNot = alum_not;
                    }

                    //const materias = Object.keys(datNot);

                    const pageContent = [
                      {
                        table: {
                          widths: [80, 70, 35, 35, 35, 30, 30, 65, 70],
                          body: [
                            [
                              {
                                rowSpan: 5,
                                image: img_logo,
                                width: 80,
                                height: 80,
                              },
                              {
                                text: "INFORME ACADÉMICO - CENTRO PEDAGÓGICO LA INMACULADA",
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
                                text: "LICENCIA DE FUNCIONAMIENTO",
                                style: "tableSubTitulo",
                                colSpan: 2,
                                alignment: "center",
                              },
                              {},
                              {
                                text: "744 DEL 01 DE JUNIO DE 2023 (DANE: 308433000654)",
                                style: "tableTexto",
                                colSpan: 6,
                                alignment: "center",
                              },
                              {},
                              {},
                              {},
                              {},
                              {},
                            ],
                            [
                              {},
                              {
                                text: "NOMBRE DEL ESTUDIANTE",
                                style: "tableSubTitulo",
                                colSpan: 2,
                                alignment: "center",
                              },
                              {},
                              {
                                text:
                                  datMat.per_ape +
                                  " " +
                                  datMat.sdo_ape +
                                  " " +
                                  datMat.per_nom +
                                  " " +
                                  datMat.sdo_nom,
                                style: "tableTexto",
                                colSpan: 6,
                                alignment: "center",
                              },
                              {},
                              {},
                              {},
                              {},
                              {},
                            ],
                            [
                              {},
                              {
                                text: "MATRÍCULA",
                                style: "tableSubTitulo",
                                colSpan: 2,
                                alignment: "center",
                              },
                              {},
                              {
                                text: "2024" + aluId,
                                style: "tableTexto",
                                colSpan: 4,
                                alignment: "center",
                              },
                              {},
                              {},
                              {},
                              {
                                text: "ID ESTUDIANTE",
                                style: "tableSubTitulo",
                                colSpan: 1,
                                alignment: "center",
                              },
                              {
                                text: aluId,
                                style: "tableTexto",
                                colSpan: 1,
                                alignment: "center",
                              },
                            ],
                            [
                              {},
                              {
                                text: "CURSO",
                                style: "tableSubTitulo",
                                colSpan: 2,
                                alignment: "center",
                              },
                              {},
                              {
                                text: datMat.gra_esc + ' (' + datMat.gra_sec + ')',
                                style: "tableTexto",
                                colSpan: 4,
                                alignment: "center",
                              },
                              {},
                              {},
                              {},
                              {
                                text: "PERIODO",
                                style: "tableSubTitulo",
                                colSpan: 1,
                                alignment: "center",
                              },
                              {
                                text: per,
                                style: "tableTexto",
                                colSpan: 1,
                                alignment: "center",
                              },
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
                        pageBreak: "after",
                        table: {
                          widths: [
                            10, 55, 34.7, 34.7, 34.7, 34.7, 34.7, 34.7, 34.7,
                            34.7, 34.7, 46,
                          ],
                          // headerRows: 3,
                          // keepWithHeaderRows: 1,
                          body: [],
                        },
                      },
                    ]

                    let materiasInfo;
                    if (
                      alumSector === "PRI" ||
                      alumSector === "SEC" ||
                      alumSector === "BAC"
                    ) {
                      materiasInfo = materiasDesc;
                      pageContent[1].table.body.push([
                        {
                          text: "Materia",
                          style: "tableTitulo",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {
                          text: "Fortalezas",
                          style: "tableTitulo",
                          colSpan: 3,
                          alignment: "center",
                        },
                        {},
                        {},
                        {
                          text: "Debilidades",
                          style: "tableTitulo",
                          colSpan: 3,
                          alignment: "center",
                        },
                        {},
                        {},
                        {
                          text: "Recomendaciones",
                          style: "tableTitulo",
                          colSpan: 3,
                          alignment: "center",
                        },
                        {},
                        {},
                        {
                          text: "Rendimiento",
                          style: "tableTitulo",
                          colSpan: 1,
                          alignment: "center",
                        },
                      ]);
                    } else {

                      if (gradoNum === "14") {
                        materiasInfo = materiasTra;
                        pageContent[1].table.body.push([
                          {
                            text: "DIMENSIÓN",
                            style: "tableTitulo",
                            colSpan: 4,
                            alignment: "center",
                          },
                          {},
                          {},
                          {},
                          {
                            text: "Fortalezas, debilidades y recomendaciones",
                            style: "tableTitulo",
                            colSpan: 7,
                            alignment: "center",
                          },
                          {},
                          {},
                          {},
                          {},
                          {},
                          {},
                          {
                            text: "Rendimiento",
                            style: "tableTitulo",
                            colSpan: 1,
                            alignment: "center",
                          },
                        ]);
                      } else {
                        materiasInfo = materiasJar;
                        pageContent[1].table.body.push([
                          {
                            text: "DIMENSIÓN",
                            style: "tableTitulo",
                            colSpan: 4,
                            alignment: "center",
                          },
                          {},
                          {},
                          {},
                          {
                            text: "Fortalezas, debilidades y recomendaciones",
                            style: "tableTitulo",
                            colSpan: 7,
                            alignment: "center",
                          },
                          {},
                          {},
                          {},
                          {},
                          {},
                          {},
                          {
                            text: "Rendimiento",
                            style: "tableTitulo",
                            colSpan: 1,
                            alignment: "center",
                          },
                        ]);
                      }

                    }

                    // Obtener las claves del objeto materiasDesc en un array
                    const ordenMaterias = Object.keys(materiasInfo);

                    // Ordenar el array de claves según el valor ordMat de cada materia
                    ordenMaterias.sort(
                      (a, b) => materiasInfo[a].ordMat - materiasInfo[b].ordMat
                    );

                    // Crear un array de promesas para almacenar todas las llamadas asíncronas
                    const promesas = ordenMaterias.map(async (materia) => {
                      const nombMateria = materiasInfo[materia].nombMateria;
                      const ordMat = materiasInfo[materia].ordMat;
                      const matDesc = materiasInfo[materia].matDesc;
                      const matRut = materiasInfo[materia].matRut;

                      let ftz_final;
                      let deb_final;
                      let rec_final;

                      let data_ftz = {
                        cmd: "sqlftz",
                        mat: materia,
                        gra: datMat.gra_esc,
                        user_id: useId,
                      };

                      const response_ftz = await fetch(
                        "modelos/notas-modelo.php",
                        {
                          method: "POST",
                          headers: { "Content-Type": "application/json" },
                          body: JSON.stringify(data_ftz),
                        }
                      );
                      const dataServer_ftz = await response_ftz.json();

                      if (dataServer_ftz.respuesta === "exito") {
                        let dat_ftz = JSON.parse(dataServer_ftz.data);

                        let ftz_array =
                          datNot["m-" + materia] &&
                            datNot["m-" + materia]["ftz"]
                            ? datNot["m-" + materia]["ftz"].split("+")
                            : [];
                        ftz_final =
                          ftz_array.length > 0
                            ? dat_ftz[ftz_array[0]][ftz_array[1]][ftz_array[2]][
                            ftz_array[3]
                            ]
                            : "S/N";

                        let deb_array =
                          datNot["m-" + materia] &&
                            datNot["m-" + materia]["deb"]
                            ? datNot["m-" + materia]["deb"].split("+")
                            : [];
                        deb_final =
                          deb_array.length > 0
                            ? dat_ftz[deb_array[0]][deb_array[1]][deb_array[2]][
                            deb_array[3]
                            ]
                            : "S/N";

                        let rec_array =
                          datNot["m-" + materia] &&
                            datNot["m-" + materia]["rec"]
                            ? datNot["m-" + materia]["rec"].split("+")
                            : [];
                        rec_final =
                          rec_array.length > 0
                            ? dat_ftz[rec_array[0]][rec_array[1]][rec_array[2]][
                            rec_array[3]
                            ]
                            : "S/N";

                        let ncnFinal =
                          datNot["m-" + materia] &&
                            datNot["m-" + materia]["ncn"]
                            ? datNot["m-" + materia]["ncn"]
                            : 0;
                        matPro = matPro + parseFloat(ncnFinal);

                        let ncnFinal_clt;
                        let ncnFinal_badged;
                        if (ncnFinal in rendimientos[alumSector]) {
                          ncnFinal_clt = rendimientos[alumSector][ncnFinal][0];
                          ncnFinal_badged =
                            rendimientos[alumSector][ncnFinal][1];
                        }

                        if (ncnFinal_clt === "BAJO") {
                          matPer += 1;
                        }

                        if (alumSector === "TRA") {
                          const responseMatImg = await fetch(matRut);
                          const blobMatImg = await responseMatImg.blob();
                          const matImgBase64 = await convertirImagenABase64(
                            blobMatImg
                          );
                          const matImg = matImgBase64;

                          pageContent[1].table.body.push([
                            {
                              image: matImg,
                              width: 163,
                              height: 75,
                              colSpan: 4,
                            },
                            {},
                            {},
                            {},
                            {
                              text: [
                                {
                                  text: "Fortalezas: ",
                                  style: "tableTexto",
                                  alignment: "justify",
                                  bold: true,
                                },
                                {
                                  text: ftz_final + "\n",
                                  style: "tableTexto",
                                  alignment: "justify",
                                },
                                {
                                  text: "Debilidades: ",
                                  style: "tableTexto",
                                  alignment: "justify",
                                  bold: true,
                                },
                                {
                                  text: deb_final + "\n",
                                  style: "tableTexto",
                                  alignment: "justify",
                                },
                                {
                                  text: "Recomendaciones: ",
                                  style: "tableTexto",
                                  alignment: "justify",
                                  bold: true,
                                },
                                {
                                  text: rec_final,
                                  style: "tableTexto",
                                  alignment: "justify",
                                },
                              ],
                              colSpan: 7,
                            },
                            {},
                            {},
                            {},
                            {},
                            {},
                            {},
                            {
                              text: [
                                { text: ncnFinal + "\n", style: "tableTexto" },
                                { text: ncnFinal_clt, style: ncnFinal_badged },
                              ],
                              //style: "tableTexto",
                              colSpan: 1,
                              alignment: "center",
                            },
                          ]);
                        } else {
                          pageContent[1].table.body.push([
                            {
                              text: nombMateria,
                              style: "tableTexto",
                              colSpan: 2,
                              alignment: "center",
                            },
                            {},
                            {
                              text: ftz_final,
                              style: "textoFtz",
                              colSpan: 3,
                              alignment: "justify",
                            },
                            {},
                            {},
                            {
                              text: deb_final,
                              style: "textoFtz",
                              colSpan: 3,
                              alignment: "justify",
                            },
                            {},
                            {},
                            {
                              text: rec_final,
                              style: "textoFtz",
                              colSpan: 3,
                              alignment: "justify",
                            },
                            {},
                            {},
                            {
                              text: [
                                { text: ncnFinal + "\n", style: "tableTexto" },
                                { text: ncnFinal_clt, style: ncnFinal_badged },
                              ],
                              //style: "tableTexto",
                              colSpan: 1,
                              alignment: "center",
                            },
                          ]);
                        }
                      }
                    });

                    // Esperar a que se completen todas las llamadas asíncronas de las materias
                    await Promise.all(promesas);

                    const notCnv = async () => {
                      let dcv_id = datNot["dcv"] ? datNot["dcv"] : 0;
                      let dcv2_id = datNot["dcv2"] ? datNot["dcv2"] : 0;
                      let dcv3_id = datNot["dcv3"] ? datNot["dcv3"] : 0;
                      let des_dcv1 = "S/X";
                      let des_dcv2 = "S/X";
                      let des_dcv3 = "S/X";

                      if (dcv_id > 0 || dcv2_id > 0 || dcv3_id > 0) {
                        let data_cnv = {
                          cmd: "sqlcnv",
                          dcv_id: dcv_id,
                          dcv2_id: dcv2_id,
                          dcv3_id: dcv3_id,
                          user_id: useId,
                        };

                        const response_cnv = await fetch(
                          "modelos/notas-modelo.php",
                          {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(data_cnv),
                          }
                        );
                        const dataServer_cnv = await response_cnv.json();

                        if (dataServer_cnv.respuesta === "exito") {
                          des_dcv1 = dataServer_cnv.dcv_desc;
                          des_dcv2 = dataServer_cnv.dcv_desc2;
                          des_dcv3 = dataServer_cnv.dcv_desc3;
                        } else {
                          des_dcv1 = "S/P";
                          des_dcv2 = "S/P";
                          des_dcv3 = "S/P";
                        }
                      } else {
                        des_dcv1 = "S/S";
                        des_dcv2 = "S/S";
                        des_dcv3 = "S/S";
                      }

                      let cnvFinal = datNot["ncv"] ? datNot["ncv"] : "S/N";
                      let cnvFinal_clt;
                      let cnvFinal_badged;
                      if (cnvFinal in rendimientos[alumSector]) {
                        cnvFinal_clt = rendimientos[alumSector][cnvFinal][0];
                        cnvFinal_badged = rendimientos[alumSector][cnvFinal][1];
                      }

                      pageContent[1].table.body.push([
                        {
                          text: "CONVIVENCIA",
                          style: "tableTexto",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {

                          text: [
                            { text: 'Estudiante: ' + des_dcv1 + ' ' + des_dcv2 + '\n', style: "textoFtz", alignment: "justify" },
                            { text: 'Padres: ' + des_dcv3, style: "textoFtz", alignment: "justify" }
                          ],
                          style: "textoFtz",
                          colSpan: 9,
                          alignment: "justify",
                        },
                        {},
                        {},
                        {},
                        {},
                        {},
                        {},
                        {},
                        {},
                        {
                          text: [
                            { text: cnvFinal + "\n", style: "tableTexto" },
                            { text: cnvFinal_clt, style: cnvFinal_badged },
                          ],
                          //style: "tableTexto",
                          colSpan: 1,
                          alignment: "center",
                        },
                      ]);
                    };

                    await notCnv(); // Esperar a que se complete la ejecución de la nota de convivencia

                    if (alumSector != "TRA") {
                      const notIcfes = async () => {
                        let icfesFinal = datNot["icf"] ? datNot["icf"] : 0;

                        let icf_rend;
                        let icf_badge;
                        let icf_rangos;

                        if (icfesFinal >= 0 && icfesFinal <= 221) {
                          icf_rend = "INSUFICIENTE";
                          icf_badge = "badgeBajo";
                        } else if (icfesFinal >= 222 && icfesFinal <= 325) {
                          icf_rend = "BÁSICO";
                          icf_badge = "badgeBasico";
                        } else if (icfesFinal >= 326 && icfesFinal <= 437) {
                          icf_rend = "SATISFÁCTORIO";
                          icf_badge = "badgeAlto";
                        } else if (icfesFinal >= 438) {
                          icf_rend = "AVANZADO";
                          icf_badge = "badgeSuperior";
                        }
                        icf_rangos =
                          "0 - 221 (INSUFICIENTE), 222 - 325 (BÁSICO), 326 - 437 (SATISFÁCTORIO), 438 - 500 (AVANZADO)";

                        pageContent[1].table.body.push([
                          {
                            text: "SIMULACROS ICFES",
                            style: "tableTexto",
                            colSpan: 2,
                            alignment: "center",
                          },
                          {},
                          {
                            text: icf_rangos,
                            style: "textoFtz",
                            colSpan: 9,
                            alignment: "left",
                          },
                          {},
                          {},
                          {},
                          {},
                          {},
                          {},
                          {},
                          {},
                          {
                            text: [
                              { text: icfesFinal + "\n", style: "tableTexto" },
                              { text: icf_rend, style: icf_badge },
                            ],
                            //style: "tableTexto",
                            colSpan: 1,
                            alignment: "center",
                          },
                        ]);
                      };

                      await notIcfes(); // Esperar a que se complete la ejecución de la nota ICFES
                    }

                    const datosFinales = async () => {
                      if (alumSector === "TRA") {
                        escala_rangos =
                          "0 - 3.1 (BAJO), 3.2 - 3.9 (BÁSICO), 4 - 4.5 (ALTO), 4.6 - 5 (SUPERIOR)";
                        if (gradoNum === "14") {
                          matEv = 7
                        } else {
                          matEv = 6
                        }
                      } else if (alumSector === "PRI") {
                        escala_rangos =
                          "0 - 3.1 (BAJO), 3.2 - 3.9 (BÁSICO), 4 - 4.5 (ALTO), 4.6 - 5 (SUPERIOR)";
                        matEv = 10;
                      } else if (alumSector === "SEC") {
                        escala_rangos =
                          "0 - 3.3 (BAJO), 3.4 - 4 (BÁSICO), 4.1 - 4.5 (ALTO), 4.6 - 5 (SUPERIOR)";
                        matEv = 10;
                      } else if (alumSector === "BAC") {
                        escala_rangos =
                          "0 - 3.7 (BAJO), 3.8 - 4 (BÁSICO), 4.1 - 4.5 (ALTO), 4.6 - 5 (SUPERIOR)";
                        matEv = 10;
                      }

                      pageContent[1].table.body.push([
                        {
                          text: "Materias evaluadas",
                          style: "tableTitulo",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {
                          text: matEv,
                          style: "tableTexto",
                          colSpan: 1,
                          alignment: "center",
                        },
                        {
                          text: "Materias perdidas",
                          style: "tableTitulo",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {
                          text: matPer,
                          style: "tableTexto",
                          colSpan: 1,
                          alignment: "center",
                        },
                        {
                          text: "Posición en el curso",
                          style: "tableTitulo",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {
                          text: "",
                          style: "tableTexto",
                          colSpan: 1,
                          alignment: "center",
                        },
                        {
                          text: "Promedio",
                          style: "tableTitulo",
                          colSpan: 2,
                          alignment: "center",
                        },
                        {},
                        {
                          text: ((parseFloat(matPro).toFixed(1)) / matEv).toFixed(1),
                          style: "tableTexto",
                          colSpan: 1,
                          alignment: "center",
                        },
                      ]);

                      pageContent[1].table.body.push(
                        [
                          {
                            text: "Escala valorativa",
                            style: "tableTitulo",
                            colSpan: 2,
                            alignment: "center",
                          },
                          {},
                          {
                            text: escala_rangos,
                            style: "textoFtz",
                            colSpan: 10,
                            alignment: "left",
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
                        [
                          {
                            text: "",
                            style: "tableTexto",
                            colSpan: 12,
                            border: [false, false, false, false],
                            margin: [0, 10, 0, 0],
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
                            style: "tableTexto",
                            colSpan: 12,
                            border: [false, false, false, false],
                            margin: [0, 10, 0, 0],
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
                        ]
                      );

                      matPer = 0;
                      matPro = 0;

                    };

                    await datosFinales(); // Esperar a que se agreguen los datos finales

                    const datosFirma = async () => {
                      const responseFirma = await fetch(firmaRuta);
                      const blobFirma = await responseFirma.blob();
                      const firmaRutaBase64 = await convertirImagenABase64(blobFirma);
                      const firma = firmaRutaBase64;

                      if (gradoNum === '14') {
                        /* pageContent[1].table.body.push(
                          [
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                              text: '',
                              style: "textoFtz",
                              colSpan: 1,
                              alignment: "left",
                              border: [false, false, false, false],

                            },
                            {
                              text: 'Firma director de grupo',
                              style: "textoFtz",
                              colSpan: 2,
                              alignment: "left",
                              border: [false, false, false, false],
                            },
                            {
                            },
                            {
                              image: firma,
                              width: 80,
                              height: 40,
                              border: [false, false, false, false],
                              colSpan: 3,
                            },
                            {
                            },
                            {
                            },
                          ]
                        ); */
                      } else {
                        pageContent[1].table.body.push([
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "",
                            style: "textoFtz",
                            colSpan: 1,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {
                            text: "Firma director de grupo",
                            style: "textoFtz",
                            colSpan: 2,
                            alignment: "left",
                            border: [false, false, false, false],
                          },
                          {},
                          {
                            image: firma,
                            width: 80,
                            height: 40,
                            border: [false, false, false, false],
                            colSpan: 3,
                          },
                          {},
                          {},
                        ]);
                      }

                    };

                    await datosFirma(); // Esperar a que se agreguen los datos finales

                    docDefinition.content.push(pageContent);

                  }

                }

                //console.log(docDefinitions);

                const pdfDoc = pdfMake.createPdf(docDefinition);
                pdfDoc.open();


              }
            } catch (error) {
              console.error("Error:", error);
            }
          };

          consultaAlumnos();

        });
      });
    } catch (error) {
      // Manejo de errores
    }
  })();

});
