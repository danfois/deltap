var DatatablesDataSourceAjaxClient = function () {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function () {
        var table = $('#m_table_1').DataTable({
            responsive: true,
            ajax: {
                url: '/json/expirations',
                type: 'GET',
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
                {data: 'title'},
                {data: 'description'},
                {data: 'expirationDate'},
                {data: 'createdAt'},
                {data: 'createdBy'},
                {data: 'issuedInvoiceNumber'},
                {data: 'receivedInvoiceNumber'},
                {data: 'isResolved'},
                {data: 'azioni'}
            ],
            columnDefs: [
                {
                    targets:0,
                    "width" : "30px"
                },
                {
                    targets: 9,
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
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'edit-expiration-'+ row.idv+ '\', {\'id\' : ' + row.idv + '}, { \'initializeForm\' : true, \'formJquery\' : \'form_expiration_edit\', \'initializeWidgets\' : true } )"><i class="la la-edit"></i> Modifica Scadenza</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'delete-expiration-' + row.idv + '\', \'Scadenza NON eliminata!\', {} )"><i class="la la-trash"></i> Elimina Scadenza</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequestToastr(\'GET\', \'set-expiration-status/' + row.idv + '/1\', {}, function() { $(\'#m_table_1\').DataTable().ajax.reload(); } )"><i class="la la-check"></i> Segna come Risolto</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequestToastr(\'GET\', \'set-expiration-status/' + row.idv + '/0\', {}, function() { $(\'#m_table_1\').DataTable().ajax.reload(); })"><i class="la la-close"></i> Segna come Non Risolto</a>\
						  	</div>\
						</div>\
					</div>\
					';
                    },
                },
                {
                    targets: 8,
                    render: function (data, type, full, meta) {
                        var status = {
                            "Si": {'title': 'Risolto', 'class': 'success'},
                            "No": {'title': 'Non Risolto', 'class': 'danger'}
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge m-badge--' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
            ],
            initComplete: function() {
                var rowFilter = $('<tr class="filter"></tr>').appendTo($('thead'));

                this.api().columns().every(function() {
                    var column = this;
                    var input;

                    switch (column.title()) {
                        case 'ID':
                        // case 'idv':
                        case 'Titolo':
                        case 'Descrizione':
                        case 'Data Scadenza':
                        case 'Creata il':
                        case 'Creata da':
                        case 'Fattura Emessa':
                        case 'Fattura Ricevuta':
                        case 'Stato':
                            input = $('<input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + column.index() + '"/>');
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

    var table = $('#m_table_1').DataTable();

});