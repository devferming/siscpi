
document.addEventListener("DOMContentLoaded", function () {
  function exportarExcelPorMateria(datNotas, per) {
    const workbook = XLSX.utils.book_new();

    for (const materia in datNotas) {
      for (const grado in datNotas[materia]) {
        const alumnos = datNotas[materia][grado];

        // Obtener los logros que comiencen con "l"
        const logros = Object.entries(alumnos[Object.keys(alumnos)[0]].notas)
          .filter(([logro]) => logro.startsWith("l"))
          .map(([logro]) => logro);

        const headers = ["N°", "APELLIDOS Y NOMBRES", "DESEMPEÑO"];

        const row2 = ["", "", ""];

        let logroNumber = 1;
        for (const logro of logros) {
          headers.push("PROPOSITO " + logroNumber);
          logroNumber++;
          row2.push("A1", "A2", "A3", "70%", "A4", "20%", "A5", "10%", "DEF");
        }

        const data = [headers];
        data.push(row2);

        let contador = 1;
        for (const alumno of Object.values(alumnos)) {
          const row = [contador, alumno.nom, alumno.notas.ncn];

          // Agregar las notas de cada logro
          let ev1 = 0;
          let ev2 = 0;
          let ev3 = 0;
          let ev4 = 0;
          let ev5 = 0;
          let def70 = 0;
          let def20 = 0;
          let def10 = 0;
          let def = 0;

          for (const logro of logros) {
            const notasLogro = alumno.notas[logro];

            if (notasLogro) {
              ev1 = parseFloat(notasLogro["ev1"]);
              ev2 = parseFloat(notasLogro["ev2"]);
              ev3 = parseFloat(notasLogro["ev3"]);
              ev4 = parseFloat(notasLogro["ev4"]);
              ev5 = parseFloat(notasLogro["ev5"]);
              def70 = ((ev1 + ev2 + ev3) / 3) * 0.7;
              def20 = ev4 * 0.2;
              def10 = ev5 * 0.1;
              def = def70 + def20 + def10;

              row.push(ev1.toFixed(1));
              row.push(ev2.toFixed(1));
              row.push(ev3.toFixed(1));
              row.push(def70.toFixed(1));
              row.push(ev4.toFixed(1));
              row.push(def20.toFixed(1));
              row.push(ev5.toFixed(1));
              row.push(def10.toFixed(1));
              row.push(def.toFixed(1));
            } else {
              row.push("", "", "", "", "", "", "", "", ""); // Espacios vacíos si no hay notas para el logro
            }
          }

          data.push(row);
          contador++;
        }

        const worksheet = XLSX.utils.aoa_to_sheet(data);

        // Establecer manualmente el ancho de las columnas (en píxeles)
        const columnWidths = [
          { wpx: 23 }, // Columna 1
          { wpx: 300 }, // Columna 2
          { wpx: 93 }, // Columna 3
          // Columnas 4 a 30 (27px cada una)
          ...Array.from({ length: 27 }, () => ({ wpx: 27 })),
        ];
        worksheet["!cols"] = columnWidths;

        // Combinar celdas A1 con A2
        const mergeA = { s: { r: 0, c: 0 }, e: { r: 1, c: 0 } };
        worksheet["!merges"] = worksheet["!merges"] || [];
        worksheet["!merges"].push(mergeA);

        // Combinar celdas B1 con B2
        const mergeB = { s: { r: 0, c: 1 }, e: { r: 1, c: 1 } };
        worksheet["!merges"].push(mergeB);

        // Combinar celdas C1 con C2
        const mergeC = { s: { r: 0, c: 2 }, e: { r: 1, c: 2 } };
        worksheet["!merges"].push(mergeC);

        // Combinar celdas para los encabezados de logros y subdivisiones
        let colOffset = 3;
        let logroNumber2 = 1;
        for (const logro of logros) {
          const colMergeStart = colOffset;
          const colMergeEnd = colMergeStart + 9;

          // Verificar si worksheet["!merges"] existe y si no, inicializarlo como un arreglo vacío
          worksheet["!merges"] = worksheet["!merges"] || [];

          worksheet["!merges"].push({
            s: { r: 0, c: colMergeStart },
            e: { r: 0, c: colMergeEnd - 1 },
          });

          nombreCeldaCombinada = "PROPOSITO " + logroNumber2;
          worksheet[XLSX.utils.encode_cell({ r: 0, c: colMergeStart })] = {
            t: "s",
            v: nombreCeldaCombinada,
          };
          colOffset = colMergeEnd;
          logroNumber2++;
        }

        XLSX.utils.book_append_sheet(
          workbook,
          worksheet,
          `${materia} - Grado ${grado}`
        );
      }
    }

    const nombreArchivo = `Planilla Notas P${per}.xlsx`;
    XLSX.writeFile(workbook, nombreArchivo);
  }

  let planillas = document.querySelectorAll(".planillas");
  planillas.forEach((planilla) => {

    const planillaButton = document.querySelector(`#${planilla.id}`);

    planillaButton.addEventListener("click", async (event) => {
      const per = planillaButton.dataset.per;
      const use = planillaButton.dataset.use;
      const mod = planillaButton.dataset.model;

      // Asigna el valor de la variable data aquí
      data = {
        cmd: "planilla",
        per: per,
        user_id: use,
      };

      try {
        const response = await fetch(mod, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });

        const dataServer = await response.json();

        if (dataServer.respuesta === "exito") {
          const datNotas = JSON.parse(dataServer.datos);
          exportarExcelPorMateria(datNotas, per);
        } else {
          console.log("Error");
        }
      } catch (error) {
        console.error(error);
      }
    });
  });

});