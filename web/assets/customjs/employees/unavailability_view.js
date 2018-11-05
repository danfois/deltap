var UnavailabilityList = function () {

    var unavailabilityList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/employee-unavailabilities'
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
                    title: 'Id Indisponibilità',
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
                    field: 'employee',
                    title: 'Dipendente'
                },
                {
                    field: 'startDate',
                    title: 'Data Inizio',
                    width: 100
                }, {
                    field: 'endDate',
                    title: 'Data Fine',
                    sortable: 'asc',
                    width: 100
                }, {
                    field: 'issue',
                    title: 'Motivo',
                    sortable: 'asc'
                },
                {
                    field: 'status',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Non Disponibile', 'class': 'm-badge--danger'},
                            2: {'title': 'Disponibile', 'class': ' m-badge--success'},
                            3: {'title': 'Quasi Disponibile', 'class': ' m-badge--warning'}
                        };
                        return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                    }
                },
                {
                    //todo: sistemare la cosa del registrare pagamento
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
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'edit-employeeUnavailability-'+row.idv+'\', {}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_unavailability_edit\'})"><i class="la la-edit"></i> Modifica Indisponibilità</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="deleteUnavailability(' + row.idv + ')"><i class="la la-trash"></i> Elimina Indisponibilità</a>\
						  	</div>\
						</div>\
						<a href="javascript:void(0);" onclick="editUnavailability('+ row.idv +')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="deleteUnavailability(' + row.idv + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina">\
							<i class="la la-trash"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {processing: "Caricamento...", noRecords: "Nessun Record nel Database"},
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} indisponibilità"
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
            if(select_value === '3') UnavailabilityBatchDelete(selected);
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
            unavailabilityList();
        }
    };
}();

$(document).ready(function() {
    UnavailabilityList.init();
});