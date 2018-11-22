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

                            height: fixChildTableHeight(),

                            footer: !1,
                            spinner: {type: 1, theme: "default"}
                        },
                        sortable: !0,
                        columns: [{
                            field: "id",
                            title: "Id Itin.",
                            width:80
                        },
                            {
                                field: "code",
                                title: "Codice Itinerario"
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
                                title: "Data Partenza"
                            },
                            {
                                field: "arrivalDate",
                                title: "Data Arrivo"
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
                                        <a class="dropdown-item" href="' + window.location.origin + '/edit-pq-detail-' + row.idv + '" onclick=""><i class="la la-edit"></i> Modifica Itinerario</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-price-quotation-detail-status\', {\'id\' : '+row.idv+', \'status\' : 2}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Conferma Itinerario</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-price-quotation-detail-status\', {\'id\' : '+row.idv+', \'status\' : 1}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Rimuovi Conferma</a>\
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'stage-details\', {\'id\' : ' + row.idv + ' })"><i class="la la-eye"></i> Vedi Tragitti</a>\
                                        <a class="dropdown-item" href="/confirm-service-orders-' + row.idv +'" onclick=""><i class="la la-list-alt"></i> Emetti Ordini di Servizio</a>\
                                    </div>\
                                </div>\
                                    <a href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'stage-details\', {\'id\' : ' + row.idv + ' })" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Tragitti"><i class="la la-eye"></i></a>\
                                    <a href="javascript:void(0);" onclick="alert(\'Serve questa funzionalita?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina Itinerario">\
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
                {
                    field: 'idv',
                    title: 'Id',
                    width: 30
                },
                {
                    field: 'code',
                    title: 'Codice',
                    width:80
                },
                {
                    field: 'date',
                    title: 'Data'
                },
                {
                    field: 'customer',
                    title: 'Cliente',
                    sortable: true
                },
                // {
                //     field: 'sender',
                //     title: 'Mittente'
                // },
                // {
                //     field: 'recipient',
                //     title: 'Destinatario'
                // },
                {
                    field:'author',
                    title: 'Autore'
                },
                {
                    field: 'service',
                    title: 'Servizio',
                    sortable: 'asc',
                    // template: function (row) {
                    //
                    //     var status = {
                    //         'Tour': {'title': 'Tour', 'class': 'm-badge--warning'},
                    //         'Noleggio': {'title': 'Noleggio', 'class': ' m-badge--info'},
                    //         'Scuola': {'title': 'Scuola', 'class': ' m-badge--brand'},
                    //         'Escursione': {'title': 'Escursione', 'class': ' m-badge--success'},
                    //     };
                    //     return '<span class="m-badge ' + status[row.service].class + ' m-badge--wide">' + status[row.service].title + '</span>';
                    // }
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
						    	<a class="dropdown-item" href="' + window.location.origin + '/edit-price-quotation-' + row.idv + '"><i class="la la-edit"></i> Modifica Preventivo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'In Lavorazione\')"><i class="la la-eye"></i> Vedi Preventivo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericModalFunction(\'GET\', \'associated-demands-'+row.idv+'\', {}, {})"><i class="la la-eye"></i> Richieste Associate</a>\
						    	<a class="dropdown-item" href="' + window.location.origin + '/create-price-quotation-detail-' + row.idv + ' " onclick=""><i class="la la-plus-circle"></i> Aggiungi Itinerario</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="alert(\'Invierà per email il preventivo al destinatario. Il preventivo sarà compreso di un file pdf per ogni itinerario, e della `lettera` che sarà il testo della mail\')"><i class="la la-envelope"></i> Invia al Destinatario</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-price-quotation-status\', {\'id\' : ' + row.idv + ', \'status\' : 3}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-check"></i> Conferma Preventivo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'GET\', \'change-price-quotation-status\', {\'id\' : ' + row.idv + ', \'status\' : 4}, $(\'.m_datatable\').mDatatable(\'reload\'))"><i class="la la-close"></i> Annulla Preventivo</a>\
						    	\<a class="dropdown-item" href="javascript:void(0);" onclick="generateInvoiceUrl(\'issued\', \'priceQuotation\', [' + row.idv + '])"><i class="la la-file"></i> Registra Fattura</a>\
						  	</div>\
						</div>\
						<a href="' + window.location.origin + '/edit-price-quotation-' + row.idv + '" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica Preventivo">\
							<i class="la la-edit"></i>\
						</a>\
						\<a href="' + window.location.origin + '/create-price-quotation-detail-' + row.idv + ' " onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Aggiungi Itinerario">\
							<i class="la la-plus-circle"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="alert(\'Questo pulsante servirà per stampare a video il pdf del preventivo\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Vedi Preventivo">\
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

