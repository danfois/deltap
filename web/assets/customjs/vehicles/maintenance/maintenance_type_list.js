var MaintenanceList = function () {

    var maintenanceList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/maintenance-types'
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
                {
                    field: 'id',
                    title: 'Id Man.',
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
                    field: 'name',
                    title: 'Nome'
                },
                {
                    field: 'dateInterval',
                    title: 'Intervallo Date',
                    sortable: true,
                    template: function (row) {
                        if(row.dateInterval == undefined) return 'Nessuno';
                        var status = {
                            '1 month' : {'title': 'Mensile', 'class': 'danger'},
                            '2 months' : {'title': 'Bimestrale', 'class': 'warning'},
                            '3 months' : {'title': 'Trimestrale', 'class': 'warning'},
                            '4 months' : {'title': 'Quadrimestrale', 'class': 'warning'},
                            '6 months' : {'title': 'Semestrale', 'class': 'brand'},
                            '1 year' : {'title': 'Annuale', 'class': 'success'},
                            '2 years' : {'title': 'Biennale', 'class': 'success'},
                            '3 years' : {'title': 'Triennale', 'class': 'success'},
                            '4 years' : {'title': 'Quadriennale', 'class': 'accent'},
                            '5 years' : {'title': 'Quinquiennale', 'class': 'accent'},
                            '10 years' : {'title': 'Decennale', 'class': 'metal'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.dateInterval].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.dateInterval].class + '">' + status[row.dateInterval].title + '</span>';
                    }
                },
                {
                    field: 'kmInterval',
                    title: 'Intervallo Km',
                    sortable: true
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
						<a href="javascript:void(0)" onclick="genericModalFunction(\'GET\', \'edit/maintenance-type-' + row.id + '\', { \'id\' : ' + row.id + '}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_maintenance_type_edit\'})" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Tipo Manutenzione">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="genericDelete(\'delete-maintenance-type\', \'Tipo manutenzione NON eliminato\', {\'id\' : ' + row.idv + '})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina Tipo Manutenzione">\
							<i class="la la-trash"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun tipo manutenzione"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} tipi manutenzione"
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
            maintenanceList();
        }
    };
}();

