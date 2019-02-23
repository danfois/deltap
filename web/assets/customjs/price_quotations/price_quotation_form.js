var PriceQuotation = function () {
    var i;
    var e;
    var t = $("#form_price_quotation");
    return {
        init: function () {
            var r;
            t = $("#form_price_quotation");
            i = t.validate({
                ignore: ":hidden",
                rules: {},
                messages: {},
                invalidHandler: function (e, r) {
                    mUtil.scrollTop();
                    swal({
                        title: "",
                        text: "Ci sono alcuni errori nel form.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                    mApp.unblockPage();
                },
                submitHandler: function (e) {
                }
            });

            (r = t.find(':submit')).on("click", function (e) {
                e.preventDefault();
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Caricamento..."
                });

                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: 'Preventivo Multiplo creato con successo!',
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        genericAjaxRequest('GET', 'set-demand-pq', {'demand' : window.idDemand, 'pq' : response});
                        setTimeout(window.location.href =  window.location.origin + '/create-price-quotation-detail-' + response, 2500);
                        $('.m_datatable').mDatatable('reload');
                    },
                    error: function (e) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: e.responseText,
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                    }
                }))
            })
        }
    }
}();
