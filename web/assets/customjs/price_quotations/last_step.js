var LastStep = function () {

    //Mi servono i valori degli input Sez. 1
    var PriceQuotation = $('#price_quotation_detail_priceQuotation option:selected').text();
    var CodiceItinerario = $('#price_quotation_detail_name').val();
    var FrequenzaServizio = $('#price_quotation_detail_serviceType option:selected').text();
    var TipoServizio = $('#price_quotation_detail_serviceCode option:selected').text();

    //Display nella prima tabella dei valori che ho trovato
    $('#n_prev').html(PriceQuotation);
    $('#cod_it').html(CodiceItinerario);
    $('#fr_s').html(FrequenzaServizio);
    $('#t_s').html(TipoServizio);

    //Ora devo trovare tutti gli accordion item all'interno dei quali ho le varie tappe (tragitti)
    var Tragitti = $('#itinerari .m-accordion__item');

    //Per comodità mi salvo un elenco delle intestazioni che creerò dinamicamente qui sotto
    var Headings = ['Partenza', 'Arrivo', 'Data Part.', 'Data Arr.', 'N. Bus', 'Pass.', 'Km', 'Tempo', 'Prezzo', 'Ore Part', 'Ore Arr', 'Giorni Ripetuti', 'Tranne'];
    var Fields = ['departureLocation', 'arrivalLocation', 'departureDate', 'arrivalDate', 'busNumber', 'passengers', 'km', 'estimatedTime', 'price', 'start_time', 'end_time', 'repeatedDays', 'leftouts'];

    $('#riepilogo-itinerari').html('');

    //devo iterare i vari tragitti e fare una tabella per ogni tragitto
    Tragitti.each(function (e, i) {

        //qui sto creando la tabella di base, l'head e il body
        var table = $('<table>').addClass('table m-table m-table--head-separator-in');
        var thead = $('<thead>');
        var tbody = $('<tbody>');
        var tr = $('<tr>');

        //itero lungo tutte le intestazioni per fare la prima riga della tabella
        Headings.forEach(function (e) {
            var th = $('<th>').text(e);
            tr.append(th);
        });

        //appendo la riga appena fatta all'head e l'head alla tabella
        thead.append(tr);
        table.append(thead);

        //creo la riga del corpo della tabella
        var trbody = $('<tr>');

        //iterazione dei campi che ho nell'array Fields
        Fields.forEach(function (o) {
            //inizializzo la variabile
            var value;
            //trattamento particolare per il prezzo e per i giorni ripetuti
            if (o === 'price') {
                value = this.find("input[name*='[price]']").val();
            } else if(o === 'repeatedDays') {
                //cerco tutti quelli che contengono RepeatedDays nell'id e se son checkati prendo il testo del parent
                this.find("input[id*='repeatedDays']").each(function(e) {
                    if($(this).is(':checked')) {
                        var val = $(this).parent().text();
                        if(val) {
                            //se value è undefined la riempio altrimenti aggiungo
                            if(value === undefined) {
                                value = val + ', ';
                            } else {
                                value += val + ', ';
                            }
                        }
                    }
                });
            }
            else {
                //trattamento di default per gli input
                value = this.find("input[name*=" + o + "]").val();
            }
            var td = $('<td>').text(value);
            trbody.append(td);
        }.bind($(this)));

        table.append(trbody);

        //appendo la tabella finita al div di riferimento
        $('#riepilogo-itinerari').append(table);
    });


};