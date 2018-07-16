jQuery.extend(jQuery.validator.messages, {
    required: "Il campo è obbligatorio.",
    remote: "Correggi questo campo.",
    email: "Inserisci un indirizzo email valido.",
    url: "Per favore inserisci un URL valido.",
    date: "Per favore inserisci una data valida.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Per favore inserisci un valore numerico valido.",
    digits: "Inserisci solo numeri.",
    creditcard: "Formato numero carta di credito non corretto.",
    equalTo: "Inserisci lo stesso valore.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});