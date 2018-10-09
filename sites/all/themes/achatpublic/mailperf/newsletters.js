function timestamp() {
    var fullDate = new Date()
    var twoDigitMonth = ((fullDate.getMonth()+1) < 10 ? '0' : '') + (fullDate.getMonth()+1);
    var twoDigitDay = (fullDate.getDate() < 10 ?  '0' : '') + (fullDate.getDate());

    return fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDay;
};

function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
};

$(function() {
    $('[id^=news_]').on('change',function(){
        var field = this.id.replace("news_","");
        $('#' + field).val( $('#news_' + field).is(':checked') ?  timestamp() : '' );
    });

});

$.validator.setDefaults({
    submitHandler: function() {
        $("#f2870").val( $('#f2985').val() + '|' + $('#f2979').val() );
        $('#theForm').submit();
    }
});

$().ready(function() {
    $("#f2979").focus();
//    $("[name='f3050']").attr('id','f3050');
    $("#f3050").val($("[name='source']").val());

    $('#theForm').get(0).setAttribute('action', 'http://f1.mailperf.com/V5/save.aspx');

    $("#theForm").validate({
        messages: {
            f2978: "Veuillez préciser votre civilité",
            f2979: "Veuillez saisir votre nom de famille",
            f2980: "Veuillez saisir votre prénom",
            f2981: "Veuillez saisir le nom de votre organisation",
            f2982: "Veuillez sélectionner un secteur d'activité",
            f2985: "Veuillez saisir une adresse e-mail valide",
            f2991: "Veuillez saisir votre code postal",
            f2993: "Veuillez sélectionner votre pays"
        }
    });
});

