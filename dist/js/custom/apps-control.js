$(document).ready(function () {



  'use strict'



/*configuracion de tabla de matriculados*/



$(function () {

  $('#mat-lista').DataTable({

    "paging": true,

    "lengthChange": false,

    "pageLength": 80,

    "searching": true,

    "ordering": true,

    "info": true,

    "autoWidth": false,

    "responsive": true,

    'language'    : {

      paginate: {

        next: 'Siguiente',

        previous: 'Anterior',

        last: 'Último',

        first: 'Primero'

      },

      info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',

      emptyTable: 'No hay registros',

      infoEmpty: '0 Registros',

      search: 'Buscar: '

    }

  });

});





$(function () {

  $('#asig-lista').DataTable({

    "paging": false,

    "lengthChange": false,

    "pageLength": 80,

    "searching": false,

    "ordering": false,

    "info": true,

    "autoWidth": false,

    "responsive": true,

    'language'    : {

      paginate: {

        next: 'Siguiente',

        previous: 'Anterior',

        last: 'Último',

        first: 'Primero'

      },

      info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',

      emptyTable: 'No hay registros',

      infoEmpty: '0 Registros',

      search: 'Buscar: '

    }

  });

});



$(function () {

  $('#alum-reporte').DataTable({

    "paging": false,

    "lengthChange": false,

    "pageLength": 80,

    "searching": false,

    "ordering": true,

    "info": false,

    "autoWidth": false,

    "responsive": true,

    'language'    : {

      paginate: {

        next: 'Siguiente',

        previous: 'Anterior',

        last: 'Último',

        first: 'Primero'

      },

      info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',

      emptyTable: 'No hay registros',

      infoEmpty: '0 Registros',

      search: 'Buscar: '

    }

  });

});





$("#tablageneral").DataTable({

  "responsive": true,

  "lengthChange": false,

  "autoWidth": false,

  "order": false,

  "pageLength": 100,

  //"buttons": ["excel", "pdf", "print"],

  'language'    : {

      paginate: {

        next: 'Siguiente',

        previous: 'Anterior',

        last: 'Último',

        first: 'Primero'

      },

      buttons: {

          "print": "Imprimir"

      },

      info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',

      emptyTable: 'No hay registros',

      infoEmpty: '0 Registros',

      search: 'Buscar: ',

    }

}).buttons().container().appendTo('#tablageneral_wrapper .col-md-6:eq(0)');

$("#tablaplanilla").DataTable({

  "responsive": true,

  "lengthChange": false,

  "autoWidth": false,

  "order": false,

  "pageLength": 100,

  "buttons": ["excel"],

  'language'    : {

      paginate: {

        next: 'Siguiente',

        previous: 'Anterior',

        last: 'Último',

        first: 'Primero'

      },

      buttons: {

          "print": "Imprimir"

      },

      info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',

      emptyTable: 'No hay registros',

      infoEmpty: '0 Registros',

      search: 'Buscar: ',

    }

}).buttons().container().appendTo('#tablaplanilla_wrapper .col-md-6:eq(0)');






return false

});

