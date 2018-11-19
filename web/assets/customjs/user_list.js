var UserList = function () {

    var userList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/users'
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
                    title: 'Id',
                    sortable: false,
                    width: 20,
                    selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                },
                {
                    field: 'username',
                    title: 'Username'
                },
                {
                    field: 'employee',
                    title: 'Dipendente'
                },
                {
                    field: 'roles',
                    title: 'Livelli'
                },
                {
                    field: 'status',
                    title: 'Stato',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Attivo', 'class': 'success'},
                            0: {'title': 'Non attivo', 'class': 'danger'}
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
                        \<div class="dropdown ' + dropup + '">\
                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                        <i class="la la-ellipsis-h"></i>\
                                    </a>\
                                    <div class="dropdown-menu dropdown-menu-right">\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'employee-to-user-'+row.idv+'\', {}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_employee_to_user\'});"><i class="la la-user-plus"></i> Associa Dipendente</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-user-status\', {\'status\' : 1, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Imposta come Attivo</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-user-status\', {\'status\' : 0, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Imposta come Disattivo</a>\
                                    </div>\
                                </div>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun utente trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Utenti"
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

        $('#m_datatable_remove_row').on('click', function () {
            datatable.rows('.m-datatable__row--active').remove();
        });
    };

    return {
        init: function () {
            userList();
        }
    };
}();

