function controleSubmitNewsletter(){
	valid=true;
	$('.pp_content_container #form_newsletter .erreur').empty().hide();

	$(".pp_content_container #form_newsletter .erreur").siblings(':input').each(function(){
		if(!$.trim($(this).val()) || $.trim($(this).val())=="Nom *" || $.trim($(this).val())=="CP *" || $.trim($(this).val())=="E-mail *" || $.trim($(this).val())=="Organisme *" || $.trim($(this).val())=="Téléphone *" ){
			$(this).siblings(".erreur:first").html("Champ obligatoire");
			valid=false;
		}
	});
	
	filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	if($('.pp_content_container #form_newsletter .email_newsletter').val()!="" && !filter.test($('.pp_content_container #form_newsletter .email_newsletter').val()) && $('.pp_content_container #form_newsletter .email_newsletter').siblings(".erreur:first").html() == ''){
		$('.pp_content_container #form_newsletter .email_newsletter').siblings(".erreur:first").html("Email invalide");
		valid=false;
	}
	
	$('.pp_content_container #form_newsletter .erreur').fadeIn('slow');

	return valid;
}

function showResponseNewsletter(responseText, statusText){
	if(statusText == 'success'){
		$(".form_newsletter_visible").addClass("hide");
		$(".form_newsletter_result").removeClass("hide");
	}
} 

$(document).ready(function(){	
	// Javascript Newsletter
	$("#form_newsletter_before").submit(function(){
		$("#show_newsletter_form_overlay").click();
		return false;
	});
	
	$("#form_newsletter_before a[rel^='prettyPhoto']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#newsletter_form',
		callback: function(){
			$(".form_newsletter_visible").removeClass("hide");
			$(".form_newsletter_result").addClass("hide");
			$(".email_newsletter").attr('value', 'E-mail *');
		},
		changepicturecallback: function(){
			$(".form_newsletter").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_newsletter");
				}
			});
			
			$('#form_newsletter').ajaxForm({ url: '/node/71' , type: "post", beforeSubmit: controleSubmitNewsletter, success: showResponseNewsletter } );
			
			$("#form_newsletter input[type=text]").each(function(){
				$(this).focus(function(){
					if(!$(this).attr("alt")){
						$(this).attr("alt", $(this).val());
					}
					if($(this).attr("alt") == $(this).val()){
						$(this).val("");
					}
				});
				
				$(this).blur(function(){
					if($.trim($(this).val())=="") $(this).val($(this).attr("alt"));
				});
			});
			$(".email_newsletter").blur();
			$(".email_newsletter").focus();
			$(".email_newsletter").attr('value', $("#input_newsletter_right").val());
		}
	});
	// Fin Javacript Newsletter
});