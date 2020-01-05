var EmployeeList = function () {

    var employeeList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/employees'
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
                    title: 'Id Dipendente',
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
                    field: 'code',
                    title: 'Cod.'
                },
                {
                    field: 'name',
                    title: 'Nominativo',
                    sortable: true
                },
                {
                    field: 'type',
                    title: 'Tipologia',
                    width: 100,
                    template: function (row) {
                        var status = {
                            1 : {'title': 'Fisso', 'class': 'info'},
                            2 : {'title': 'Occasionale', 'class': 'warning'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.type].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.type].class + '">' + status[row.type].title + '</span>';
                    }
                }, {
                    field: 'payGrade',
                    title: 'Inquadramento'
                }, {
                    field: 'email',
                    title: 'Email',
                    width: 200
                },
                {
                    field: 'phone',
                    title: 'Telefono'
                },
                {
                    field: 'mobile',
                    title: 'Cellulare'
                },
                {
                    field: 'fired',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            0 : {'title': 'Attivo', 'class': 'm-badge--success'},
                            1 : {'title': 'Licenziato', 'class': ' m-badge--danger'}
                        };
                        return '<span class="m-badge ' + status[row.fired].class + ' m-badge--wide">' + status[row.fired].title + '</span>';
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
						    	<a class="dropdown-item" href="edit-employee-'+ row.id +'"><i class="la la-edit"></i> Modifica Dipendente</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'employee-details\', { \'id\' : ' + row.id + '})"><i class="la la-eye"></i> Vedi Dettagli</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/create-driving-license\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_driving_license\' });"><i class="la la-plus-circle"></i> Aggiungi Patente</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/create-driving-letter\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_driving_letter\' });"><i class="la la-plus-circle"></i> Aggiungi Carta Conducente</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/create-qualification-letter\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_qualification_letter\' });"><i class="la la-plus-circle"></i> Aggiungi Carta Qualificazione Conducente</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/create-curriculum\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_curriculum\' });"><i class="la la-plus-circle"></i> Aggiungi Curriculum</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'attendances/' + row.id + '\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_attendances\', \'repeater\': true }, );"><i class="la la-graduation-cap"></i> Corsi Frequentati</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'ajax/terminate-employee\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_terminate\' });"><i class="la la-ban"></i> Cessazione Rapporto</a>\
						  	</div>\
						</div>\
						<a href="edit-employee-'+ row.id +'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Dipendente">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'employee-details\', { \'id\' : ' + row.id + '})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Dettagli">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun dipendente trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} dipendenti"
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
            employeeList();
        }
    };
}();

