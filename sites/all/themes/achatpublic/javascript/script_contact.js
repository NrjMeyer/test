$(document).ready(function(){
	//Javascript Formulaire Contact
	$("#form_contact input[type=text]").each(function(){
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
		
	$("#form_contact").submit(function(){
		valid=true;
		validCheckbox=false;
		$('#form_contact .erreur').empty().hide();
		$('#form_contact #erreur_input_radio').empty().hide();
		
		$("#form_contact .erreur").siblings(':input').each(function(){
			if(!$.trim($(this).val()) || $.trim($(this).val())=="Nom *" || $.trim($(this).val())=="CP *" || $.trim($(this).val())=="E-mail *" || $.trim($(this).val())=="Organisme *" || $.trim($(this).val())=="Téléphone *" ){
				$(this).siblings(".erreur:first").html("Champ obligatoire");
				valid=false;
			}
		});
		
		filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		
		if($('#form_contact #edit-email').val()!="" && !filter.test($('#form_contact #edit-email').val()) && $('#form_contact #edit-email').siblings(".erreur:first").html() == ''){
			$('#form_contact #edit-email').siblings(".erreur:first").html("Email invalide");
			valid=false;
		}
		
		$('#form_contact .erreur').fadeIn('slow');

		return valid;
	});
	//Fin Javascript Formulaire Contact
});