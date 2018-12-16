var PurchaseOrderList = function () {

    var purchaseOrderList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/purchase-orders'
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
                                    url: "json/purchase-order-details",
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
                                field: 'quantity',
                                title: 'Qtà'
                            },
                            {
                                field: 'description',
                                title: 'Descrizione'
                            },
                            {
                                field:'vehicle',
                                title: 'Veicolo'
                            }
                            ],
                        translate: {
                            records: {
                                processing: "Caricamento...",
                                noRecords: "Nessun dettaglio per questo Ordine"
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
                    field: 'orderDate',
                    title: 'Data Ordine',
                    width: 80,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) < parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) > parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                {
                    field: 'expirationDate',
                    title: 'Data Scadenza',
                    width: 80,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) < parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) > parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                },{
                    field: 'deliveryDate',
                    title: 'Data Consegna',
                    width: 80,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) < parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                var dateA = aField.split('-');
                                var dateB = bField.split('-');

                                if(parseInt(dateA[2]) > parseInt(dateB[2])) {
                                    return 1;
                                } else {
                                    if(parseInt(dateA[2]) < parseInt(dateB[2])) {
                                        return -1;
                                    } else {
                                        if(parseInt(dateA[1]) > parseInt(dateB[1])) {
                                            return 1;
                                        } else {
                                            if(parseInt(dateA[1]) < parseInt(dateB[1])) {
                                                return -1;
                                            } else {
                                                if(parseInt(dateA[0]) > parseInt(dateB[0])) {
                                                    return 1;
                                                } else {
                                                    return -1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                {
                    field: 'provider',
                    title: 'Fornitore'
                },
                {
                    field: 'referencePerson',
                    title: 'Persona Riferimento'
                },
                {
                    field: 'employee',
                    title: 'Mittente'
                },
                {
                    field: 'referent',
                    title: 'Referente'
                },
                {
                    field: 'orderType',
                    title: 'Tipologia',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Richiesta Prev.', 'class': 'brand'},
                            2: {'title': 'Ordine Acquisto', 'class': 'info'},
                            3: {'title': 'Ordine Verbale', 'class': 'accent'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.orderType].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.orderType].class + '">' + status[row.orderType].title + '</span>';
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
						    	<a class="dropdown-item" href="edit-purchase-order-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Ordine di Acquisto</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Ordine di Acquisto</a>\
						  	</div>\
						</div>\
						<a href="edit-purchase-order-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Ordine di Acquisto">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="alert(\'In Lavorazione\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Ordine di Acquisto">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun Ordine di Acquisto trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} Ordini di Acquisto"
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
            purchaseOrderList();
        }
    };
}();

