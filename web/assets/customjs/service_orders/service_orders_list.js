var ServiceOrderList = function () {

    var serviceOrderList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/service-orders'
                    }
                },
                pageSize: 20
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 650
            },
            sortable: true,
            pagination: true,
            search: {
                input: $('#generalSearch')
            },
            columns: [
                {
                    field: 'id',
                    title: 'Id OdS',
                    sortable: false,
                    width: 40,
                    selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                },
                {
                    field: 'idv',
                    title: 'Id',
                    width: 30
                },
                {
                    field: 'pq',
                    title: 'Preventivo'
                },
                {
                    field: 'pqd',
                    title: 'Itinerario'
                },
                {
                    field: 'customer',
                    title: 'Cliente',
                    sortable: true
                },
                {
                    field: 'driver',
                    title: 'Autista'
                },
                {
                    field: 'vehicle',
                    title: 'Veicolo'
                },
                {
                    field: 'departureLocation',
                    title: 'Partenza'
                },
                {
                    field: 'arrivalLocation',
                    title: 'Arrivo'
                },
                {
                    field: 'departureDate',
                    title: 'Data Part.'
                },
                {
                    field: 'arrivalDate',
                    title: 'Data Arr.'
                },
                {
                    field: 'time',
                    title: 'Orari'
                },
                {
                    field: 'passengers',
                    title: 'Passeggeri'
                },
                {
                    field: 'frequency',
                    title: 'Freq. Servizio'
                },
                {
                    field: 'service',
                    title: 'Servizio',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            'Tour': {'title': 'Tour', 'class': 'm-badge--warning'},
                            'Noleggio': {'title': 'Noleggio', 'class': ' m-badge--info'}
                        };
                        return '<span class="m-badge ' + status[row.service].class + ' m-badge--wide">' + status[row.service].title + '</span>';
                    }
                },
                {
                    field: 'price',
                    title: 'Prezzo'
                },
                /*{
                    field: 'status',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Da Inviare', 'class': 'warning'},
                            2: {'title': 'Inviato', 'class': 'info'},
                            3: {'title': 'Confermato', 'class': 'success'},
                            4: {'title': 'Annullato', 'class': 'metal'},
                        };
                        return '<span class="m-badge m-badge--' + status[row.status].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.status].class + '">' + status[row.status].title + '</span>';
                    }
                },*/
                {
                    field: 'Actions',
                    width: 110,
                    title: 'Azioni',
                    sortable: false,
                    overflow: 'visible',
                    template: function (row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                        return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a class="dropdown-item" href="edit-service-order-' + row.idv +'" onclick=""><i class="la la-edit"></i> Modifica Ordine di Servizio</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Dettagli</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'assign-driver-and-vehicle\', {\'id\' : ' + row.idv +'}, { \'initializeForm\' : true, \'formJquery\' : \'form_assign_driver_vehicle\' } )"><i class="la la-plus-circle"></i> Assegna Autista e Veicolo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-check"></i> Segna come Eseguito</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-close"></i> Segna come Annullato</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'ajax/delete-service-order-' + row.idv +'\', \'Ordine di Servizio NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Ordine di Servizio</a>\
						  	</div>\
						</div>\
						<a href="javascript:void(0);" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Ordine di Servizio">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="alert(\'In Lavorazione\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Ordine di Servizio">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun Ordine di Servizio trovato"
                },
                toolbar: {
                    pagination: {
                        items: {
                            default: {
                                first: "Primo",
                                prev: "Precedente",
                                next: "Successivo",
                                last: "Ultimo",
                                more: "Più Pagine",
                                input: "Numero di Pagina",
                                select: "Seleziona il numero della pagina"
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Ordini di Servizio"
                        }
                    }
                }
            }
        };

        var datatable = $('.m_datatable').mDatatable(options);

        $('#m_datatable_destroy').on('click', function () {
            $('.m_datatable').mDatatable('destroy');
        });

        $('#m_datatable_init').on('click', function () {
            datatable = $('.m_datatable').mDatatable(options);
        });

        $('#m_datatable_reload').on('click', function () {
            $('.m_datatable').mDatatable('reload');
        });

        $('#m_datatable_sort').on('click', function () {
            $('.m_datatable').mDatatable('sort', 'ShipCity');
        });

        // get checked record and get value by column name
        $('#m_datatable_get').on('click', function () {
            // select active rows
            datatable.rows('.m-datatable__row--active');
            // check selected nodes
            if (datatable.nodes().length > 0) {
                // get column by field name and get the column nodes
                var value = datatable.columns('idv').nodes().text();
                $('#datatable_value').html(value);
                alert(value);
            }
        });

        $('#m_datatable_check').on('click', function () {
            var input = $('#m_datatable_check_input').val();
            datatable.setActive(input);
        });

        $('#m_datatable_check_all').on('click', function () {
            $('.m_datatable').mDatatable('setActiveAll', true);
        });

        $('#m_datatable_uncheck_all').on('click', function () {
            $('.m_datatable').mDatatable('setActiveAll', false);
        });

        $('#m_datatable_hide_column').on('click', function () {
            datatable.columns('Currency').visible(false);
        });

        $('#m_datatable_show_column').on('click', function () {
            datatable.columns('Currency').visible(true);
        });

        $('#m_datatable_remove_row').on('click', function () {
            datatable.rows('.m-datatable__row--active').remove();
        });
    };

    return {
        init: function () {
            serviceOrderList();
        }
    };
}();

