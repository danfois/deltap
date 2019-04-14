var DatatablesDataSourceAjaxClient = function () {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function () {
        var table = $('#m_table_1').DataTable({
            responsive: true,
            ajax: {
                url: '/json/service-orders',
                type: 'POST',
                dataSrc: "",
                data: {
                    pagination: {
                        perpage: 50
                    }
                }
            },
            // "oSearch": {"sSearch": $('#min').val() },
            language: {
                "sEmptyTable":     "Nessun dato presente nella tabella",
                "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
                "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
                "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Visualizza _MENU_ elementi",
                "sLoadingRecords": "Caricamento...",
                "sProcessing":     "Elaborazione...",
                "sSearch":         "Cerca:",
                "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
                "oPaginate": {
                    "sFirst":      "Inizio",
                    "sPrevious":   "Precedente",
                    "sNext":       "Successivo",
                    "sLast":       "Fine"
                },
                "oAria": {
                    "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
                    "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                }
            },
            columns: [
                {data: 'id'},
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
                {data: 'azioni'}
            ],
            columnDefs: [
                {
                    targets:0,
                    "width" : "30px"
                },
                {
                    targets:2,
                    "width" : "100px"
                },
                {
                    targets:3,
                    "width" : "100px"
                },
                {
                  targets: [6,7],
                    "type" : "html-input"
                },
                {
                    targets: 14,
                    title: 'Azioni',
                    "width" : "150px",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                        return '<div style="width:100%">\
						<div class="dropdown" style="display:inline-block">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a target="_blank" class="dropdown-item" href="edit-service-order-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Ordine di Servizio</a>\
						    	<a target="_blank" class="dropdown-item" href="print/service-order-' + row.idv + '"><i class="la la-eye"></i> Vedi OdS</a>\
						    	<a target="_blank" class="dropdown-item" href="print/repeated-service-order-' + row.idv + '"><i class="la la-eye"></i> Vedi OdS Ripetitivo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'assign-driver-and-vehicle\', {\'id\' : ' + row.idv + '}, { \'initializeForm\' : true, \'formJquery\' : \'form_assign_driver_vehicle\' } )"><i class="la la-plus-circle"></i> Assegna Autista e Veicolo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'mass-driver-and-vehicle-assignment-' + row.idv + '\', {\'id\' : ' + row.idv + '}, { \'initializeForm\' : true, \'formJquery\' : \'form_assign_driver_vehicle\' } )"><i class="la la-plus-circle"></i> Assegna in massa Autista e Veicolo</a>\
						    	\<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="generateInvoiceUrl(\'issued\', \'serviceOrders\', [' + row.idv + '])"><i class="la la-file"></i> Registra Fattura</a>\
						    	<a target="_blank" class="dropdown-item" href="drivers/create-report-' + row.idv + '" onclick=""><i class="la la-plus-circle"></i> Compila Report</a>\
						    	<a target="_blank" class="dropdown-item" href="drivers/edit-report-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Report</a>\
						    	<a target="_blank" class="dropdown-item" href="drivers/report-problems-' + row.idv + '" onclick=""><i class="la la-close"></i> Segnala Problemi</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'report-detail\', {\'id\' : ' + row.idv + '}, {} )"><i class="la la-eye"></i> Visualizza Report</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'view-problems-' + row.idv + '\', {\'id\' : ' + row.idv + '}, {} )"><i class="la la-flag"></i> Visualizza Problemi</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv + ', \'status\' : 2})"><i class="la la-check"></i> Segna come Eseguito</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv + ', \'status\' : 3})"><i class="la la-close"></i></i> Segna come Annullato</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'ajax/delete-service-order-' + row.idv + '\', \'Ordine di Servizio NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Ordine di Servizio</a>\
						  	</div>\
						</div>\
						<a target="_blank" href="edit-service-order-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Ordine di Servizio">\
							<i class="la la-edit"></i>\
						</a>\
						<a target="_blank" href="print/service-order-' + row.idv + '" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Ordine di Servizio">\
							<i class="la la-eye"></i>\
						</a></div>\
					';
                    },
                },
                {
                    targets: 8,
                    render: function (data, type, full, meta) {
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
                    targets: 13,
                    "width" : "120px",
                    render: function (data, type, row, meta) {
                        var status = {
                            0: {'title': 'Status non Impostato', 'class': 'metal'},
                            1: {'title': 'Da Eseguire', 'class': 'warning'},
                            2: {'title': 'Eseguito', 'class': 'success'},
                            3: {'title': 'Annullato', 'class': 'danger'}
                        };
                        if (typeof status[row.status] === 'undefined') {
                            return row.status;
                        }
                        return '<span class="m-badge m-badge--' + status[row.status].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.status].class + '">' + status[row.status].title + '</span>';
                    }
                }
            ],
            initComplete: function() {
                var rowFilter = $('<tr class="filter"></tr>').appendTo($('thead'));

                this.api().columns().every(function() {
                    var column = this;
                    var input;

                    switch (column.title()) {
                        case 'ID':
                        // case 'idv':
                        case 'Itin.':
                        case 'Data Part.':
                        case 'Data Arr.':
                        case 'Orari':
                        case 'Pass.':
                        case 'Veicolo':
                        case 'Autista':
                        case 'Cliente':
                        case 'Partenza':
                        case 'Arrivo':
                        case 'Freq.':
                        case 'Servizio':
                            input = $('<input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + column.index() + '"/>');
                            break;
                        case 'Stato':
                            var status = {
                                0: {'title': 'Status non Impostato', 'class': 'metal'},
                                1: {'title': 'Da Eseguire', 'class': 'warning'},
                                2: {'title': 'Eseguito', 'class': 'success'},
                                3: {'title': 'Annullato', 'class': 'danger'}
                            };
                            input = $('<select class="form-control form-control-sm form-filter m-input" title="Seleziona" data-col-index="' + column.index() + '">'
										+ '<option value="">Seleziona</option></select>');
                            column.data().unique().sort().each(function(d, j) {
                                $(input).append('<option value="' + status[d].title + '">' + status[d].title + '</option>');
                            });
                            break;

                        case 'Azioni':
                            var search = $('<button class="btn btn-brand m-btn btn-sm m-btn--icon" id="sortTable">\
							    <i class="la la-search"></i>\
							</button>');

                            var reset = $('<button class="btn btn-secondary m-btn btn-sm m-btn--icon" id="resetFilter" style="margin-top:0 !important;">\
							    <i class="la la-close"></i>\
							</button>');

                            $('<th>').append(search).append(reset).appendTo(rowFilter);
                            // input = $('<div>').append(search).append(reset);

                            $('#sortTable').on('click', function(e) {
                                e.preventDefault();
                                var params = {};
                                $(rowFilter).find('.m-input').each(function() {
                                    var i = $(this).data('col-index');
                                    if (params[i]) {
                                        console.log(params[i]);
                                        params[i] += $(this).val();
                                    }
                                    else {
                                        console.log(params[i]);
                                        params[i] = $(this).val();
                                    }
                                });
                                $.each(params, function(i, val) {
                                    table.column(i).search(val, false, false, true);
                                });
                                table.table().draw();
                            });

                            $('#resetFilter').on('click', function(e) {
                                e.preventDefault();
                                $(rowFilter).find('.m-input').each(function(i) {
                                    $(this).val('');
                                    table.column($(this).data('col-index')).search('', false, false);
                                });
                                table.table().draw();
                            });
                            break;
                    }

                    $(input).appendTo($('<th>').appendTo(rowFilter));
                });

                $('tr.filter').find('th:last').remove();
            }
        });
    };

    return {
        init: function () {
            initTable1();
        }
    };

}();

jQuery(document).ready(function () {
    $.fn.dataTable.moment('DD-MM-YYYY');
    DatatablesDataSourceAjaxClient.init();


    $.fn.dataTableExt.ofnSearch['html-input'] = function(value) {
        return $(value).find("option:selected").text();
    };


        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#min').datepicker("getDate");
                var max = $('#max').datepicker("getDate");
                var startDate = moment(data[3], 'DD-MM-YYYY');
                if (min == null && max == null) { return true; }
                if (min == null && startDate <= max) { return true;}
                if(max == null && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            }
        );


        $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, format:'dd-mm-yyyy' });
        $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, format: 'dd-mm-yyyy' });
        var table = $('#m_table_1').DataTable();

        // Event listener to the two range filtering inputs to redraw on input
        $('#min, #max').change(function () {
            table.draw();
        });

    $('#m_table_1').on('change', '.driver_select', function () {
        var id = $(this).attr('data-so');
        var idUser = $(this).children("option:selected").val();
        genericAjaxRequestToastr('GET', 'ajax/assign-driver-' + id, {'idUser' : idUser });
    });

    $('#m_table_1').on('change', '.vehicle_select', function () {
        var id = $(this).attr('data-so');
        var idVehicle = $(this).children("option:selected").val();
        genericAjaxRequestToastr('GET', 'ajax/assign-vehicle-' + id, {'idVehicle' : idVehicle });
    });

    $('#min').val(moment().format('DD-MM-YYYY'));


});