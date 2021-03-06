var SalaryList = function () {

    var salaryList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/salaries'
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
                                    url: "/json/salary-details",
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
                                title: 'Id Pag.',
                                sortable: false,
                                width: 20,
                                selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                            },
                            {
                                field: 'paymentDate',
                                title: 'Data',
                                width: 80
                            },
                            {
                                field: 'direction',
                                title: '<i class="la la-exchange"></i>',
                                template: function (row) {
                                    var status = {
                                        'IN': {'title': 'Entrata', 'class': 'success'},
                                        'OUT': {'title': 'Uscita', 'class': 'danger'}
                                    };
                                    return '<span class="m-badge m-badge--' + status[row.direction].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.direction].class + '">' + status[row.direction].title + '</span>';
                                },
                                width: 70
                            },
                            {
                                field: 'type',
                                title: 'Tipo',
                                sortable: 'asc',
                                width: 80,
                                template: function (row) {
                                    var status = {
                                        'CASH': {'title': 'Contanti', 'class': 'm-badge--success'},
                                        'TRANSFER': {'title': 'Bonifico', 'class': ' m-badge--info'},
                                        'CHECK': {'title': 'Assegno', 'class': ' m-badge--warning'}
                                    };
                                    return '<span class="m-badge ' + status[row.type].class + ' m-badge--wide">' + status[row.type].title + '</span>';
                                }
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
                            // {
                            //     field: 'causal',
                            //     title: 'Causale',
                            //     sortable: true,
                            //     template: function (row) {
                            //         return '<span style="font-size:11px;">' + row.causal + '</span>';
                            //     }
                            // },
                            // {
                            //     field: 'description',
                            //     title: 'Descrizione',
                            //     sortable: true,
                            //     template: function (row) {
                            //         return '<span style="font-size:11px;">' + row.description + '</span>';
                            //     }
                            // },
                            // {
                            //     field: 'customer',
                            //     title: 'Cliente/Fornitore',
                            //     sortable: true,
                            //     template: function (row) {
                            //         if (row.customer != '') {
                            //             return row.customer;
                            //         }
                            //         if (row.provider != '') {
                            //             return row.provider;
                            //         }
                            //
                            //         return 'Nessuno';
                            //     }
                            // },
                            // {
                            //     field: 'checkDate',
                            //     title: 'Dati Assegno',
                            //     width: 100,
                            //     template: function (row) {
                            //         if (row.checkDate != null && row.checkNumber != null) {
                            //             return row.checkDate + ' - ' + row.checkNumber;
                            //         } else {
                            //             return 'N/A';
                            //         }
                            //     }
                            // },
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
						    	<a class="dropdown-item" href="edit-payment-' + row.paymentId + '" onclick=""><i class="la la-edit"></i> Modifica Pagamento</a>\
						    	<a class="dropdown-item" href="" onclick="alert(\'In Lavorazione\')"><i class="la la-print"></i> Stampa Pagamento</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'delete-salary-detail-' + row.idv + '\', \'Pagamento NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Pagamento</a>\
						  	</div>\
						</div>\
						<a href="edit-payment-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Pagamento">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="alert(\'In Lavorazione\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Dettagli Pagamento">\
							<i class="la la-eye"></i>\
						</a>\
					';
                                }
                            }],
                        translate: {
                            records: {
                                processing: "Caricamento...",
                                noRecords: "Nessun pagamento per questo stipendio"
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
                                        }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Pagamenti"
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
                    field: 'date',
                    title: 'Data',
                    width: 80,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');


                                if (parseInt(dateA[1]) < parseInt(dateB[1])) {
                                    return 1;
                                } else {
                                    if (parseInt(dateA[1]) > parseInt(dateB[1])) {
                                        return -1;
                                    } else {
                                        if (parseInt(dateA[0]) < parseInt(dateB[0])) {
                                            return 1;
                                        } else {
                                            return -1;
                                        }
                                    }
                                }


                            } else {
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');


                                if (parseInt(dateA[1]) > parseInt(dateB[1])) {
                                    return 1;
                                } else {
                                    if (parseInt(dateA[1]) < parseInt(dateB[1])) {
                                        return -1;
                                    } else {
                                        if (parseInt(dateA[0]) > parseInt(dateB[0])) {
                                            return 1;
                                        } else {
                                            return -1;
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                {
                    field: 'employee',
                    title: 'Impiegato'
                },
                {
                    field: 'causal',
                    title: 'Causale'
                },

                {
                    field: 'amount',
                    title: 'Importo',
                    template: function (row) {
                        return '&euro; ' + row.amount;
                    }
                },
                {
                    field: 'balance',
                    title: 'Saldo',
                    template: function (row) {
                        if (row.remaining != '0') {
                            return '<span class="m--font-success">&euro; ' + row.balance + '</span>' + ' / ' + '<span class="m--font-danger">&euro; ' + row.remaining + '</span>';
                        } else {
                            return '<span class="m--font-success">&euro; ' + row.balance + '</span>';
                        }
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
						    	<a class="dropdown-item" href="edit-salary-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Stipendio</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-print"></i> Stampa Stipendio</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericDelete(\'delete-salary-' + row.idv + '\', \'Stipendio NON eliminato!\', {} )"><i class="la la-trash"></i> Elimina Stipendio</a>\
						  	</div>\
						</div>\
						<a href="edit-salary-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Stipendio">\
							<i class="la la-edit"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessuno stipendio trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Stipendi"
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
            salaryList();
        }
    };
}();

