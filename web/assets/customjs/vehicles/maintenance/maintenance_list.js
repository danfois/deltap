var MaintenanceList = function () {

    var maintenanceList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/maintenances'
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
            detail: {
                title: "Caricamento...", content: function (t) {
                    $("<div/>").attr("id", "child_data_ajax_" + t.data.idv).appendTo(t.detailCell).mDatatable({
                        data: {
                            type: "remote",
                            source: {
                                read: {
                                    url: "json/maintenance-details",
                                    //headers: {"x-my-custom-header": "some value", "x-test-header": "the value"},
                                    params: {'id': t.data.idv}
                                }
                            },
                            pageSize: 10
                        },
                        layout: {
                            theme: "default",
                            scroll: !0,
                            height: 300,
                            footer: !1,
                            spinner: {type: 1, theme: "default"}
                        },
                        sortable: !0,
                        columns: [
                            {
                                field: 'id',
                                title: 'Id',
                                sortable: false,
                                width: 20,
                                selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                            },
                            {
                                field: 'maintenanceType',
                                title: 'Tipo Manutenzione'
                            },
                            {
                                field: 'description',
                                title: 'Descrizione'
                            },
                            {
                                field: 'amount',
                                title: 'Importo',
                                width: 70,
                                sortable: true,
                                template: function (row) {
                                    if (row.direction === 'IN') {
                                        return '<span class="m--font-success m--font-bold">&euro; ' + row.amount + '</span>';
                                    } else {
                                        return '<span class="m--font-danger m--font-bold">&euro; ' + row.amount + '</span>';
                                    }
                                }
                            },
                            {
                                field: 'expirationDate',
                                title: 'Data Scadenza'
                            },
                            {
                                field: 'expirationKm',
                                title: 'Km Scadenza'
                            }],
                        translate: {
                            records: {
                                processing: "Caricamento...",
                                noRecords: "Nessun dettaglio per questa scheda manutenzione"
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
                                        }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Dettagli"
                                    }
                                }
                            }
                        }
                    })
                }
            },
            columns: [
                {field: "ids", title: "", sortable: !1, width: 20, textAlign: "center"},
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
                    field: 'vehicle',
                    title: 'Veicolo'
                },
                {
                    field: 'provider',
                    title: 'Fornitore'
                },
                {
                    field: 'employee',
                    title: 'Esecutore Interno'
                },
                {
                    field: 'km',
                    title: 'Km'
                },
                {
                    field: 'startDate',
                    title: 'Date'
                },
                {
                    field: 'invoice',
                    title: 'Fattura',
                    template: function(row) {
                        return '<a href="edit-received-invoice-'+row.invoice+'"><span class="m-badge m-badge--info m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-info">'+row.invoice+'</span></span></a>';
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
						    	<a class="dropdown-item" href="generate-invoice?type=received&datatype=maintenance&data=['+row.idv+']"><i class="la la-file"></i> Registra Fattura</a>\
						  	</div>\
						</div>\
						<a href="edit-maintenance-'+row.idv+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Scheda Manutenzione">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="genericDelete(\'delete-maintenance-'+row.idv+'\', \'Scheda Manutenzione NON eliminata\', {\'id\' : ' + row.idv + '})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina Scheda Manutenzione">\
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

