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
                    width: 20
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
                            'Autonoleggio': {'title': 'Autonoleggio', 'class': 'm-badge--primary'},
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
						    	<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
						  	</div>\
						</div>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
                    }
                }]
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

