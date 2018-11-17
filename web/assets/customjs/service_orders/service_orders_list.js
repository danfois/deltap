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

            rows: {
                afterTemplate: function(row, data, index) {
                    $(row).find('.driver_select').on('change', function () {
                        var id = $(this).attr('data-so');
                        var idUser = $(this).children("option:selected").val();
                        genericAjaxRequestToastr('GET', 'ajax/assign-driver-' + id, {'idUser' : idUser });
                    });

                    $(row).find('.vehicle_select').on('change', function () {
                        var id = $(this).attr('data-so');
                        var idVehicle = $(this).children("option:selected").val();
                        genericAjaxRequestToastr('GET', 'ajax/assign-vehicle-' + id, {'idVehicle' : idVehicle });
                    });
                }
            },

            columns: [
                {
                    field: 'id',
                    title: 'Id OdS',
                    sortable: false,
                    width: 20,
                    selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                },
                {
                    field: 'pq',
                    title: 'Prev.',
                    width: 50
                },
                {
                    field: 'pqd',
                    title: 'Itin.',
                    width:50
                },
                {
                    field: 'customer',
                    title: 'Cliente',
                    sortable: true
                },
                {
                    field: 'driver',
                    title: 'Autista',
                    template: function(row) {
                        if(row.driver === 'Nessuno') {
                            return '<span class="m--font-danger">Nessuno</span>'
                        } else {
                            return '<span class="m--font-info">' + row.driver + '</span>';
                        }
                    }
                },
                {
                    field: 'vehicle',
                    title: 'Veicolo',
                    template: function(row) {
                        if(row.vehicle === 'Nessuno') {
                            return '<span class="m--font-danger">Nessuno</span>'
                        } else {
                            return '<span class="m--font-info">' + row.vehicle + '</span>';
                        }
                    }
                },
                {
                    field: 'departureLocation',
                    title: 'Partenza',
                    width: 80
                },
                {
                    field: 'arrivalLocation',
                    title: 'Arrivo',
                    width: 80
                },
                {
                    field: 'departureDate',
                    title: 'Data Part.',
                    width: 80
                },
                {
                    field: 'arrivalDate',
                    title: 'Data Arr.',
                    width: 80
                },
                {
                    field: 'time',
                    title: 'Orari',
                    template: function(row) {
                        if(row.lessThanFive === 1) {
                            return '<span class="m--font-danger">' + row.time + '</span>';
                        } else {
                            return '<span class="">' + row.time + '</span>';
                        }
                    }
                },
                {
                    field: 'passengers',
                    title: 'Pass.',
                    width:50
                },
                {
                    field: 'frequency',
                    title: 'Freq.',
                    width:50
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
                    field: 'status',
                    title: 'Stato',
                    width:80,
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            0: {'title': 'Status non Impostato', 'class': 'metal'},
                            1: {'title': 'Da Eseguire', 'class': 'warning'},
                            2: {'title': 'Eseguito', 'class': 'success'},
                            3: {'title': 'Annullato', 'class': 'danger'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.status].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.status].class + '">' + status[row.status].title + '</span>';
                    }
                },
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
						    	\<a class="dropdown-item" href="javascript:void(0);" onclick="generateInvoiceUrl(\'issued\', \'serviceOrders\', [' + row.idv + '])"><i class="la la-file"></i> Registra Fattura</a>\
						    	<a class="dropdown-item" href="create-report-' + row.idv +'" onclick=""><i class="la la-plus-circle"></i> Compila Report</a>\
						    	<a class="dropdown-item" href="edit-report-' + row.idv +'" onclick=""><i class="la la-edit"></i> Modifica Report</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'report-detail\', {\'id\' : ' + row.idv +'}, {} )"><i class="la la-eye"></i> Visualizza Report</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv +', \'status\' : 2})"><i class="la la-check"></i> Segna come Eseguito</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-service-order-status\', {\'id\' : ' + row.idv +', \'status\' : 3})"><i class="la la-close"></i></i> Segna come Annullato</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'ajax/delete-service-order-' + row.idv +'\', \'Ordine di Servizio NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Ordine di Servizio</a>\
						  	</div>\
						</div>\
						<a href="edit-service-order-' + row.idv +'" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Ordine di Servizio">\
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

        $('#apply-mass-action').on('click', function() {
            var select_value = $('#mass-action').val();
            var selected = [];
            datatable.rows('.m-datatable__row--active');
            if (datatable.nodes().length > 0) {
                var value = datatable.columns('idv').nodes().each(function(element, index) {
                    selected.push(index.childNodes[0].textContent);
                });
                console.log(selected);
            }
            //if(select_value === '2') CarTaxRenew(selected);
            if(select_value === '3') generateInvoiceUrl('issued', 'serviceOrders', selected);
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

