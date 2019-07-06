var VehicleList = function () {

    var vehicleList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/vehicles'
                    }
                },
                pageSize: 20
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 550,
                footer: false
            },
            sortable: true,
            pagination: true,
            search: {
                input: $('#generalSearch')
            },
            columns: [
                //todo: aggiungere le cose di scadenze bolli e assicurazioni, studiarsela bene
                {
                    field: 'id',
                    title: 'Id Veicolo',
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
                    field: 'plate',
                    title: 'Targa',
                    sortable: true,
                    width: 70
                },
                {
                    field: 'brand',
                    title: 'Marca',
                    width: 100
                }, {
                    field: 'model',
                    title: 'Modello',
                    width: 100
                }, {
                    field: 'seats',
                    title: 'Posti Sedere',
                    sortable: 'asc',
                    width: 70
                }, {
                    field: 'stands',
                    title: 'Posti in Piedi',
                    sortable: 'asc',
                    width: 70
                },
                {
                    field: 'owner',
                    title: 'Intestatario',
                    sortable: 'asc'
                },
                {
                    field: 'use',
                    title: 'Tipo Uso',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            'Autoscuola': {'title': 'Autoscuola', 'class': 'm-badge--primary'},
                            'Noleggio': {'title': 'Noleggio', 'class': ' m-badge--warning'},
                            'Linea': {'title': 'Linea', 'class': ' m-badge--accent'},
                            'Uso Privato': {'title': 'Uso Privato', 'class': ' m-badge--success'},
                            'Altro': {'title': 'Altro', 'class': ' m-badge--metal'}
                        };
                        return '<span class="m-badge ' + status[row.use].class + ' m-badge--wide">' + status[row.use].title + '</span>';
                    }
                }, {
                    field: 'purchaseDate',
                    title: 'Data Acquisto'
                },
                {
                    field: 'insuranceEnd',
                    title: 'Scad. Assicurazione',
                    width: 100,
                    template: function(row) {
                        return '<span style="color:red; font-weight:bold;">' + row.insuranceEnd + '</span>';
                    }
                },
                {
                    field: 'cartaxEnd',
                    title: 'Scad. Bollo',
                    width: 100,
                    template: function(row) {
                        return '<span style="color:red; font-weight:bold;">' + row.cartaxEnd + '</span>';
                    }
                },
                {
                    field: 'carreviewEnd',
                    title: 'Scad. Revisione',
                    width: 100,
                    template: function(row) {
                        return '<span style="color:red; font-weight:bold;">' + row.carreviewEnd + '</span>';
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
						    	<a class="dropdown-item" href="edit-vehicle-'+ row.id +'"><i class="la la-edit"></i> Modifica Veicolo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'vehicle-details\', { \'id\' : ' + row.id + '})"><i class="la la-eye"></i> Vedi Dettagli</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'setup-maintenances-' + row.id + '\', { \'id\' : ' + row.id + '}, {\'initializeWidgets\' : true, \'repeater\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_maintenance_setup\'})"><i class="la la-gears"></i> Imposta Manutenzioni</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="suspendInsurance(' + row.insuranceId + ')"><i class="la la-hourglass"></i> Sospendi Assicurazione</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'insurance-suspensions-table\', { \'id\' : ' + row.insuranceId + '})"><i class="la la-eye"></i> Vedi Sospensioni Ass.</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'POST\', \'ajax/renew-cartax\', { \'ids\' : JSON.stringify([' + row.carTaxId + '])})"><i class="la la-refresh"></i> Rinnova Bollo Stesse Condizioni</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/unavailability-list-vehicle\', { \'id\' : ' + row.id + '})"><i class="la la-eye"></i> Vedi Indisponibilità</a>\
						  	</div>\
						</div>\
						<a href="edit-vehicle-'+ row.id +'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Veicolo">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'vehicle-details\', { \'id\' : ' + row.id + '})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Dettagli">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun veicolo trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} veicoli"
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
            vehicleList();
        }
    };
}();

