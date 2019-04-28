var PriceQuotationList = function () {

    var priceQuotationList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/price-quotations'
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
                                    url: window.location.origin + "/json/price-quotation-details",
                                    //headers: {"x-my-custom-header": "some value", "x-test-header": "the value"},
                                    params: {'id': t.data.idv}
                                }
                            },
                            pageSize: 10
                        },
                        layout: {
                            theme: "default",
                            scroll: !0,

                            // height: fixChildTableHeight(),

                            footer: !1,
                            spinner: {type: 1, theme: "default"}
                        },
                        sortable: !0,
                        columns: [
                        //     {
                        //     field: "id",
                        //     title: "Id Itin.",
                        //     width:80
                        // },
                            {
                                field: "code",
                                title: "Codice Itinerario",
                                type: "number",
                                template: function(row) {
                                    if(row.pqCode != '') {
                                        return row.pqCode + '/' + row.code;
                                    } else {
                                        return row.code;
                                    }
                                }
                            },
                            {
                                field: "serviceType",
                                title: "Freq. Servizio"
                            },
                            {
                                field: "serviceCode",
                                title: "Tipo Servizio"
                            },

                            {
                                field: "stages",
                                title: "N. Tragitti",
                                width:80
                            },
                            {
                                field: "departureLocation",
                                title: "Partenza"
                            },
                            {
                                field: "arrivalLocation",
                                title: "Arrivo"
                            },
                            {
                                field: "departureDate",
                                title: "Data Partenza",
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
                                field: "arrivalDate",
                                title: "Data Arrivo",
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
                                field: "price",
                                title: "Prezzo",
                                width: 80,
                                template: function (row) {
                                    return '&euro; ' + row.price;
                                }
                            },
                            {
                                field: 'emittedOrders',
                                title: 'Ordini di Servizio',
                                template: function (row) {
                                    var status = {
                                        0: {'title': 'Non Emessi', 'class': 'metal'},
                                        1: {'title': 'Emessi', 'class': 'success'}
                                    };
                                    return '<span class="m-badge m-badge--' + status[row.emittedOrders].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.emittedOrders].class + '">' + status[row.emittedOrders].title + '</span>';
                                }
                            },
                            {
                                field: 'status',
                                title: 'Stato',
                                template: function (row) {
                                    if(row.status === undefined) return '';
                                    var status = {
                                        1: {'title': 'Non Confermato', 'class': 'warning'},
                                        2: {'title': 'Confermato', 'class': 'success'}
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
                                        <a target="_blank" class="dropdown-item" href="' + window.location.origin + '/edit-pq-detail-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Itinerario</a>\
                                        \<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'' + window.location.origin + '/send-pqd-modal-'+row.idv+'\', {}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_pq_email\'})"><i class="la la-envelope"></i> Invia al Destinatario</a>\
                                        <a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'' + window.location.origin + '/change-price-quotation-detail-status\', {\'id\' : '+row.idv+', \'status\' : 2}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Conferma Itinerario</a>\
                                        <a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'' + window.location.origin + '/change-price-quotation-detail-status\', {\'id\' : '+row.idv+', \'status\' : 1}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Rimuovi Conferma</a>\
                                        <a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'' + window.location.origin + '/stage-details\', {\'id\' : ' + row.idv + ' })"><i class="la la-eye"></i> Vedi Tragitti</a>\
                                        <a target="_blank" class="dropdown-item" href="' + window.location.origin + '/confirm-service-orders-' + row.idv +'" onclick=""><i class="la la-list-alt"></i> Emetti Ordini di Servizio</a>\
                                    </div>\
                                </div>\
                                    <a target="_blank" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'stage-details\', {\'id\' : ' + row.idv + ' })" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Tragitti"><i class="la la-eye"></i></a>\
                                    <a target="_blank" href="javascript:void(0);" onclick="alert(\'Serve questa funzionalita?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina Itinerario">\
							<i class="la la-trash"></i>\
						</a>\
					';
                                }
                            }],
                        translate: {
                            records: {
                                processing: "Caricamento...",
                                noRecords: "Nessun Itinerario per questo Preventivo"
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
                                        }, info: "Visualizzando {{start}} - {{end}} dì {{total}} itinerari"
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
                    title: 'Id Preventivo',
                    sortable: false,
                    width: 40,
                    selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                },
                // {
                //     field: 'idv',
                //     title: 'Id',
                //     width: 30
                // },
                {
                    field: 'code',
                    title: 'Codice',
                    type: "number",
                    width:80
                },
                {
                    field: 'date',
                    title: 'Data',
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
                    field: 'customer',
                    title: 'Cliente',
                    sortable: true
                },
                {
                    field:'author',
                    title: 'Autore'
                },
                {
                    field: 'status',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Da Inviare', 'class': 'warning'},
                            2: {'title': 'Inviato', 'class': 'info'},
                            3: {'title': 'Confermato', 'class': 'success'},
                            4: {'title': 'Annullato', 'class': 'metal'},
                            5: {'title': 'No Itinerari', 'class': 'danger'}
                        };
                        return '<span class="m-badge m-badge--' + status[row.status].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.status].class + '">' + status[row.status].title + '</span>';
                    }
                },
                {
                    field: 'Actions',
                    width: 150,
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
						    	<a target="_blank" class="dropdown-item" href="' + window.location.origin + '/edit-price-quotation-' + row.idv + '"><i class="la la-edit"></i> Modifica Preventivo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Preventivo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'' + window.location.origin + '/associated-demands-'+row.idv+'\', {}, {})"><i class="la la-eye"></i> Richieste Associate</a>\
						    	<a target="_blank" class="dropdown-item" href="' + window.location.origin + '/create-price-quotation-detail-' + row.idv + ' " onclick=""><i class="la la-plus-circle"></i> Aggiungi Itinerario</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'' + window.location.origin + '/send-pq-modal-'+row.idv+'\', {}, {\'initializeWidgets\' : true, \'initializeForm\' : true, \'formJquery\' : \'form_pq_email\'})"><i class="la la-envelope"></i> Invia al Destinatario</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'' + window.location.origin + '/change-price-quotation-status\', {\'id\' : ' + row.idv + ', \'status\' : 3}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Conferma Preventivo</a>\
						    	<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'' + window.location.origin + '/change-price-quotation-status\', {\'id\' : ' + row.idv + ', \'status\' : 4}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Annulla Preventivo</a>\
						    	\<a target="_blank" class="dropdown-item" href="javascript:void(0);" onclick="generateInvoiceUrl(\'issued\', \'priceQuotation\', [' + row.idv + '])"><i class="la la-file"></i> Registra Fattura</a>\
						  	</div>\
						</div>\
						<a target="_blank" href="' + window.location.origin + '/edit-price-quotation-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Preventivo">\
							<i class="la la-edit"></i>\
						</a>\
						\<a target="_blank" href="' + window.location.origin + '/create-price-quotation-detail-' + row.idv + ' " onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Aggiungi Itinerario">\
							<i class="la la-plus-circle"></i>\
						</a>\
						<a target="_blank" href="' + window.location.origin + '/print/price-quotation-' + row.idv + '" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Preventivo">\
							<i class="la la-eye"></i>\
						</a>\
					';
                    }
                }],
            translate: {
                records: {
                    processing: "Caricamento...",
                    noRecords: "Nessun preventivo trovato"
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} preventivi"
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
            priceQuotationList();
        }
    };
}();

