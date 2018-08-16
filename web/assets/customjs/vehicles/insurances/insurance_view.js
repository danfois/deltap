var InsuranceList = function () {

    var insuranceList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/insurances'
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
                    title: 'Id Assicurazione',
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
                    field: 'vehicle',
                    title: 'Veicolo'
                },
                {
                    field: 'company',
                    title: 'Compagnia',
                    sortable: true,
                    width: 100
                },
                {
                    field: 'number',
                    title: 'Numero'
                }, {
                    field: 'startDate',
                    title: 'Data Inizio',
                    width: 100
                }, {
                    field: 'endDate',
                    title: 'Data Scadenza',
                    sortable: 'asc',
                    width: 100
                }, {
                    field: 'price',
                    title: 'Prezzo Tot.',
                    sortable: 'asc'
                },
                {
                    field: 'flat',
                    title: 'Rata',
                    sortable: 'asc'
                },
                {
                    field: 'status',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            1: {'title': 'In Uso', 'class': 'm-badge--success'},
                            2: {'title': 'Scaduta', 'class': ' m-badge--danger'},
                            3: {'title': 'In Scadenza', 'class': ' m-badge--warning'}
                        };
                        return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
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
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="editInsurance('+ row.idv +')"><i class="la la-edit"></i> Modifica Assicurazione</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-trash"></i> Elimina Assicurazione</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-file"></i> Registra Fattura</a>\
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

        $('#m_datatable_remove_row').on('click', function () {
            datatable.rows('.m-datatable__row--active').remove();
        });
    };

    return {
        init: function () {
            insuranceList();
        }
    };
}();

$(document).ready(function() {
    InsuranceList.init();
});