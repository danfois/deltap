var CarTaxList = function () {

    var carTaxList = function () {

        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/json/cartaxes'
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
                    title: 'Id Bollo',
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
                    field: 'startDate',
                    title: 'Data Inizio',
                    width: 100,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');

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
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');

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
                }, {
                    field: 'endDate',
                    title: 'Data Scadenza',
                    sortable: 'asc',
                    width: 100,
                    sortCallback: function (data, sort, column) {
                        var field = column['field'];
                        return $(data).sort(function (a, b) {
                            var aField = a[field];
                            var bField = b[field];
                            if (sort === 'asc') {
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');

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
                                var dateA = aField.split('/');
                                var dateB = bField.split('/');

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
                }, {
                    field: 'price',
                    title: 'Prezzo Tot.',
                    sortable: 'asc'
                },
                {
                    field: 'status',
                    title: 'Stato',
                    sortable: 'asc',
                    template: function (row) {
                        var status = {
                            1: {'title': 'Non Scaduto', 'class': 'm-badge--success'},
                            2: {'title': 'Scaduto', 'class': ' m-badge--danger'},
                            3: {'title': 'In Scadenza', 'class': ' m-badge--warning'}
                        };
                        return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                    }
                },
                {
                    field:'active',
                    title:'Attiva',
                    template: function(row) {
                        var status = {
                            1: {'title': 'In Uso', 'class': 'success'},
                            0: {'title': 'Non in Uso', 'class': 'metal'}
                        }
                        return '<span class="m-badge m-badge--' + status[row.active].class + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.active].class + '">' + status[row.active].title + '</span>';
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
						  	    <a class="dropdown-item" href="javascript:void(0);" onclick="setActive('+ row.idv +', \'set-active-car-tax\')"><i class="la la-check"></i> Imposta come in uso</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="editCarTax('+ row.idv +')"><i class="la la-edit"></i> Modifica Bollo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="deleteCarTax(' + row.idv + ')"><i class="la la-trash"></i> Elimina Bollo</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="genericAjaxRequest(\'POST\', \'ajax/create-unavailability\', {\'id\' : ' + row.idv + ', \'type\' : \'cartax\'})"  title="Aggiungi Indisponibilità"><i class="la la-ban"></i>Aggiungi Indisponibilità</a>\
						    	<a class="dropdown-item" href="javascript:void(0);" onclick="deleteCarTax(' + row.idv + ')"><i class="la la-refresh"></i> Rinnova Bollo stesse condizioni</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-file"></i> Registra Fattura</a>\
						  	</div>\
						</div>\
						<a href="javascript:void(0);" onclick="editCarTax('+ row.idv +')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Modifica">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:void(0);" onclick="deleteCarTax(' + row.idv + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Elimina">\
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
                            }, info: "Visualizzando {{start}} - {{end}} dì {{total}} bolli"
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
            if(select_value === '2') CarTaxRenew(selected);
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
            carTaxList();
        }
    };
}();

$(document).ready(function() {
    CarTaxList.init();
});