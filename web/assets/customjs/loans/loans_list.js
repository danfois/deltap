var LoanList = function () {

    var loanList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/loans'
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
            detail: {
                title: "Caricamento...", content: function (t) {
                    $("<div/>").attr("id", "child_data_ajax_" + t.data.idv).appendTo(t.detailCell).mDatatable({
                        data: {
                            type: "remote",
                            source: {
                                read: {
                                    url: "json/loan-instalments",
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
                                field: 'paymentDate',
                                title: 'Data Pag.'
                            },
                            {
                                field: 'amount',
                                title: 'Importo',
                                template: function (row) {
                                    return '&euro; ' + row.amount;
                                }
                            },
                            {
                                field: 'interestRate',
                                title: 'Interessi %',
                                template: function (row) {
                                    return row.interestRate + ' %';
                                }
                            },
                            {
                                field: 'paymentType',
                                title: 'Tipo Pag.',
                                template: function (row) {
                                    var status = {
                                        'CASH': {'title': 'Contanti', 'class': 'success'},
                                        'TRANSFER': {'title': 'Bonifico', 'class': 'info'},
                                        'CHECK': {'title': 'Assegno', 'class': 'brand'},
                                        'RID': {'title': 'RID', 'class': 'accent'},
                                    };
                                    return '<span class="m-badge m-badge--' + status[row.paymentType].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.paymentType].class + '">' + status[row.paymentType].title + '</span>';
                                }
                            },
                            {
                                field: 'bankAccount',
                                title: 'Conto Corrente'
                            }
                        ],
                        translate: {
                            records: {
                                processing: "Caricamento...",
                                noRecords: "Nessuna rata per questo mutuo"
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
                                        }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Rate"
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
                    title: 'Id',
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
                    field: 'provider',
                    title: 'Banca'
                },
                {
                    field: 'number',
                    title: 'Numero Mutuo',
                    template: function(row) {
                        return '<strong>' + row.number + '</strong>';
                    }
                },
                {
                    field: 'amount',
                    title: 'Importo Finanziato',
                    template: function (row) {
                        return '&euro; ' + row.amount;
                    }
                }, {
                    field: 'interestRate',
                    title: 'Interessi %',
                    template: function (row) {
                        return row.interestRate + ' %';
                    }
                },
                {
                    field: 'interestType',
                    title: 'Tipo Interessi',
                    template: function (row) {
                        var status = {
                            'FIXED': {'title': 'Fisso', 'class': 'success'},
                            'VARIABLE': {'title': 'Variabile', 'class': 'danger'},
                            'MIXED': {'title': 'Misto', 'class': 'warning'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.interestType].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.interestType].class + '">' + status[row.interestType].title + '</span>';
                    }
                },
                {
                    field: 'instalmentType',
                    title: 'Rateizzazione',
                    template: function (row) {
                        var status = {
                            'MONTHLY': {'title': 'Mensile', 'class': 'warning'},
                            'QUARTERLY': {'title': 'Trimestrale', 'class': 'brand'},
                            'HALFYEARLY': {'title': 'Semestrale', 'class': 'info'},
                            'YEARLY': {'title': 'Annuale', 'class': 'metal'}
                        };
                        return '<span class="m-badge ' + status[row.instalmentType].class + ' m-badge--wide">' + status[row.instalmentType].title + '</span>';
                    }
                },
                {
                    field: 'instalmentNumber',
                    title: 'N. Rate'
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
						    	<a class="dropdown-item" href="edit-loan-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Mutuo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Mutuo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'create-instalment\', {\'id\' : '+row.idv+'}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_instalment\'})"><i class="la la-plus-circle"></i> Aggiungi Rata</a>\
						  	</div>\
						</div>\
						<a href="edit-loan-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Mutuo">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="alert(\'In Lavorazione\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Mutuo">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun Mutuo trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Mutui"
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

        $('#apply-mass-action').on('click', function () {
            var select_value = $('#mass-action').val();
            var selected = [];
            datatable.rows('.m-datatable__row--active');
            if (datatable.nodes().length > 0) {
                var value = datatable.columns('idv').nodes().each(function (element, index) {
                    selected.push(index.childNodes[0].textContent);
                });
                console.log(selected);
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
            loanList();
        }
    };
}();

