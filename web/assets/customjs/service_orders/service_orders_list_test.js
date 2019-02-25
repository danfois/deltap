// var DatatablesDataSourceAjaxServer = function() {
//
//     var initTable1 = function() {
//         var table = $('#m_table_1');
//
//         // begin first table
//         table.DataTable({
//             responsive: true,
//             searchDelay: 500,
//             processing: true,
//             serverSide: true,
//             ajax: '/json/service-orders',
//             columns: [
//                 {data: 'id'},
//                 {data: 'idv'},
//                 {data: 'pqd'},
//                 {data: 'departureDate'},
//                 {data: 'arrivalDate'},
//                 {data: 'time'},
//                 {data: 'passengers'},
//                 {data: 'vehicle'},
//                 {data: 'driver'},
//                 {data: 'customer'},
//                 {data: 'departureLocation'},
//                 {data: 'arrivalLocation'},
//                 {data: 'frequency'},
//                 {data: 'service'},
//                 {data: 'status'},
//             ],
//             columnDefs: [
//                 {
//                     targets: -1,
//                     title: 'Actions',
//                     orderable: false,
//                     render: function(data, type, full, meta) {
//                         return '\
//                         <span class="dropdown">\
//                             <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\
//                               <i class="la la-ellipsis-h"></i>\
//                             </a>\
//                             <div class="dropdown-menu dropdown-menu-right">\
//                                 <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
//                                 <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
//                                 <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
//                             </div>\
//                         </span>\
//                         <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\
//                           <i class="la la-edit"></i>\
//                         </a>';
//                     },
//                 },
//                 {
//                     targets: 8,
//                     render: function(data, type, full, meta) {
//                         var status = {
//                             0: {'title': 'Status non Impostato', 'class': 'metal'},
//                             1: {'title': 'Da Eseguire', 'class': 'warning'},
//                             2: {'title': 'Eseguito', 'class': 'success'},
//                             3: {'title': 'Annullato', 'class': 'danger'}
//                         };
//                         if (typeof status[data] === 'undefined') {
//                             return data;
//                         }
//                         return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
//                     },
//                 },
//                 {
//                     targets: 9,
//                     render: function(data, type, full, meta) {
//                         var status = {
//                             1: {'title': 'Online', 'state': 'danger'},
//                             2: {'title': 'Retail', 'state': 'primary'},
//                             3: {'title': 'Direct', 'state': 'accent'},
//                         };
//                         if (typeof status[data] === 'undefined') {
//                             return data;
//                         }
//                         return '<span class="m-badge m-badge--' + status[data].state + ' m-badge--dot"></span>&nbsp;' +
//                             '<span class="m--font-bold m--font-' + status[data].state + '">' + status[data].title + '</span>';
//                     },
//                 },
//             ],
//         });
//     };
//
//     return {
//
//         //main function to initiate the module
//         init: function() {
//             initTable1();
//         },
//
//     };
//
// }();
//
// jQuery(document).ready(function() {
//     DatatablesDataSourceAjaxServer.init();
// });



var DatatablesDataSourceAjaxClient = function() {

    var initTable1 = function() {
        var table = $('#m_table_1');

        // begin first table
        table.DataTable({
            responsive: true,
            ajax: {
                url: '/json/service-orders',
                type: 'POST',
                dataSrc:"",
                data: {
                    pagination: {
                        perpage: 50,
                    },
                },
            },
            columns: [
                {data: 'id'},
                {data: 'idv'},
                {data: 'pqd'},
                {data: 'departureDate'},
                {data: 'arrivalDate'},
                {data: 'time'},
                {data: 'passengers'},
                {data: 'vehicle'},
                {data: 'driver'},
                {data: 'customer'},
                {data: 'departureLocation'},
                {data: 'arrivalLocation'},
                {data: 'frequency'},
                {data: 'service'},
                {data: 'status'},
                {data: 'actions'}
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        // var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                        return '\
						<div class="dropdown">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a target="_blank" class="dropdown-item" href="edit-service-order-' + row.idv +'" onclick=""><i class="la la-edit"></i> Modifica Ordine di Servizio</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Dettagli</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'assign-driver-and-vehicle\', {\'id\' : ' + row.idv +'}, { \'initializeForm\' : true, \'formJquery\' : \'form_assign_driver_vehicle\' } )"><i class="la la-plus-circle"></i> Assegna Autista e Veicolo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'mass-driver-and-vehicle-assignment-' + row.idv +'\', {\'id\' : ' + row.idv +'}, { \'initializeForm\' : true, \'formJquery\' : \'form_assign_driver_vehicle\' } )"><i class="la la-plus-circle"></i> Assegna in massa Autista e Veicolo</a>\
						    	\<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="generateInvoiceUrl(\'issued\', \'serviceOrders\', [' + row.idv + '])"><i class="la la-file"></i> Registra Fattura</a>\
						    	<a target="_blank" class="dropdown-item" href="create-report-' + row.idv +'" onclick=""><i class="la la-plus-circle"></i> Compila Report</a>\
						    	<a target="_blank" class="dropdown-item" href="edit-report-' + row.idv +'" onclick=""><i class="la la-edit"></i> Modifica Report</a>\
						    	<a target="_blank" class="dropdown-item" href="report-problems-' + row.idv +'" onclick=""><i class="la la-close"></i> Segnala Problemi</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'report-detail\', {\'id\' : ' + row.idv +'}, {} )"><i class="la la-eye"></i> Visualizza Report</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'view-problems-' + row.idv + '\', {\'id\' : ' + row.idv +'}, {} )"><i class="la la-flag"></i> Visualizza Problemi</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv +', \'status\' : 2})"><i class="la la-check"></i> Segna come Eseguito</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv +', \'status\' : 3})"><i class="la la-close"></i></i> Segna come Annullato</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'ajax/delete-service-order-' + row.idv +'\', \'Ordine di Servizio NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Ordine di Servizio</a>\
						  	</div>\
						</div>\
						<a target="_blank" href="edit-service-order-' + row.idv +'" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Ordine di Servizio">\
							<i class="la la-edit"></i>\
						</a>\
						<a target="_blank" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Ordine di Servizio">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    },
                },
                {
                    targets: 8,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'Status non Impostato', 'class': 'metal'},
                            1: {'title': 'Da Eseguire', 'class': 'warning'},
                            2: {'title': 'Eseguito', 'class': 'success'},
                            3: {'title': 'Annullato', 'class': 'danger'}
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: 9,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'Status non Impostato', 'class': 'metal'},
                            1: {'title': 'Da Eseguire', 'class': 'warning'},
                            2: {'title': 'Eseguito', 'class': 'success'},
                            3: {'title': 'Annullato', 'class': 'danger'}
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge m-badge--' + status[data].state + ' m-badge--dot"></span>&nbsp;' +
                            '<span class="m--font-bold m--font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

jQuery(document).ready(function() {
    DatatablesDataSourceAjaxClient.init();
});