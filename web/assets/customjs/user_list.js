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
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="window.idDemand = '+row.idv+'; genericModalFunction(\'GET\', \'popup-create-price-quotation\', {}, {\'initializeWidgets\' : true, \'callbackInit\' : PriceQuotation});"><i class="la la-file"></i> Emetti Preventivo</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'demand-status\', {\'status\' : 1, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-warning"></i> Segna come Non Risolta</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'demand-status\', {\'status\' : 2, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-exclamation"></i> Segna come In Lavorazione</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'demand-status\', {\'status\' : 3, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Segna come Risolta</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'demand-status\', {\'status\' : 4, \'id\' : '+row.idv+'}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Segna come Annullata</a>\
                                    </div>\
                                </div>\
						<a href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'edit-demand-' + row.id + '\', {\'id\': \'' + row.id + '\'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_demand_edit\' });" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Richiesta">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="genericDelete(\'ajax/delete-demand-' + row.idv +'\', \'Richiesta NON eliminata!\', {} )" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina Richiesta">\
							<i class="la la-trash"></i>\
						</a>\
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

