function controleSubmitDocumentation(){
	valid=true;
	$('.pp_content_container #form_documentation .erreur').empty().hide();

	$(".pp_content_container #form_documentation .erreur").siblings(':input').each(function(){
		if(!$.trim($(this).val()) || $.trim($(this).val())=="Nom *" || $.trim($(this).val())=="CP *" || $.trim($(this).val())=="E-mail *" || $.trim($(this).val())=="Organisme *" || $.trim($(this).val())=="Téléphone *" ){
			$(this).siblings(".erreur:first").html("Champ obligatoire");
			valid=false;
		}
	});
	
	filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	if($('.pp_content_container #form_documentation .email_documentation').val()!="" && !filter.test($('.pp_content_container #form_documentation .email_documentation').val()) && $('.pp_content_container #form_documentation .email_documentation').siblings(".erreur:first").html() == ''){
		$('.pp_content_container #form_documentation .email_documentation').siblings(".erreur:first").html("Email invalide");
		valid=false;
	}
	
	$('.pp_content_container #form_documentation .erreur').fadeIn('slow');
	
	return valid;
}

function showResponseDocumentation(responseText, statusText){
	if(statusText == 'success'){
		$(".form_documentation_visible").addClass("hide");
		$(".form_documentation_result").removeClass("hide");
	}
} 
	
$(document).ready(function(){
	//Javacript Bloc Documentation Home
	$("#right a[href$='.pdf']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#documentation_form',
		init_url_documentation: true,
		callback: function(){
			$(".form_documentation_visible").removeClass("hide");
			$(".form_documentation_result").addClass("hide");
			$(".url_return_documentation").empty();
			document.location.reload();
		},
		changepicturecallback: function(){
			$(".form_documentation").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_documentation");
				}
			});
			
			$('#form_documentation').ajaxForm( { url: '/node/71' , type: "post", target:'.url_return_documentation', beforeSubmit: controleSubmitDocumentation, success: showResponseDocumentation } );
			
			$("#form_documentation input[type=text]").each(function(){
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
			
		}
	});
	
	//Fin Javacript Bloc Documentation Home
});