function controleSubmitActualite(){
	valid=true;
	$('.pp_content_container #form_actualite .erreur').empty().hide();

	$(".pp_content_container #form_actualite .erreur").siblings(':input').each(function(){
		if(!$.trim($(this).val()) || $.trim($(this).val())=="Nom *" || $.trim($(this).val())=="CP *" || $.trim($(this).val())=="E-mail *" || $.trim($(this).val())=="Organisme *" || $.trim($(this).val())=="Téléphone *" ){
			$(this).siblings(".erreur:first").html("Champ obligatoire");
			valid=false;
		}
	});
	
	filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	if($('.pp_content_container #form_actualite .email_actualite').val()!="" && !filter.test($('.pp_content_container #form_actualite .email_actualite').val()) && $('.pp_content_container #form_actualite .email_actualite').siblings(".erreur:first").html() == ''){
		$('.pp_content_container #form_actualite .email_actualite').siblings(".erreur:first").html("Email invalide");
		valid=false;
	}
	
	$('.pp_content_container #form_actualite .erreur').fadeIn('slow');
	
	return valid;
}

function showResponseActualite(responseText, statusText){
	if(statusText == 'success'){
		$(".form_actualite_visible").addClass("hide");
		$(".form_actualite_result").removeClass("hide");
	}
} 
	
$(document).ready(function(){
	//Javacript Bloc Actualite Home
	$("#bloc_actualites a[rel^='prettyPhoto']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#actualite_form',
		init_url: true,
		callback: function(){
			$(".form_actualite_visible").removeClass("hide");
			$(".form_actualite_result").addClass("hide");
			$(".url_return_actualite").empty();
		},
		changepicturecallback: function(){
			$(".form_actualite").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_actualite");
				}
			});
			
			$('#form_actualite').ajaxForm( { url: '/node/71' , type: "post", target:'.url_return_actualite', beforeSubmit: controleSubmitActualite, success: showResponseActualite } );
			
			$("#form_actualite input[type=text]").each(function(){
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
	
	$("#left #left_centre .contenu_generic .titre_actu a[rel^='prettyPhoto']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#actualite_form',
		init_url: true,
		callback: function(){
			$(".form_actualite_visible").removeClass("hide");
			$(".form_actualite_result").addClass("hide");
			$(".url_return_actualite").empty();
		},
		changepicturecallback: function(){
			$(".form_actualite").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_actualite");
				}
			});
			
			$('#form_actualite').ajaxForm( { url: '/node/71' , type: "post", target:'.url_return_actualite', beforeSubmit: controleSubmitActualite, success: showResponseActualite } );
			
			$("#form_actualite input[type=text]").each(function(){
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
	
	$("#left #left_centre .contenu_generic .item-list p.lire_suite_actu a[rel^='prettyPhoto']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#actualite_form',
		init_url: true,
		callback: function(){
			$(".form_actualite_visible").removeClass("hide");
			$(".form_actualite_result").addClass("hide");
			$(".url_return_actualite").empty();
		},
		changepicturecallback: function(){
			$(".form_actualite").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_actualite");
				}
			});
			
			$('#form_actualite').ajaxForm( { url: '/node/71' , type: "post", target:'.url_return_actualite', beforeSubmit: controleSubmitActualite, success: showResponseActualite } );
			
			$("#form_actualite input[type=text]").each(function(){
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
	
	$("#block-views-actualite-block_2 a[rel^='prettyPhoto']").prettyPhoto({
		allowresize: false,
		theme: 'light_rounded',
		keyboard_shortcuts: false,
		custom_markup: '#actualite_form',
		init_url: true,
		callback: function(){
			$(".form_actualite_visible").removeClass("hide");
			$(".form_actualite_result").addClass("hide");
			$(".url_return_actualite").empty();
		},
		changepicturecallback: function(){
			$(".form_actualite").each(function(){
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr("id") == "pp_content_container"){
					$(this).attr("id", "form_actualite");
				}
			});
			
			$('#form_actualite').ajaxForm( { url: '/node/71' , type: "post", target:'.url_return_actualite', beforeSubmit: controleSubmitActualite, success: showResponseActualite } );
			
			$("#form_actualite input[type=text]").each(function(){
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
	
	//Fin Javacript Bloc Actualite Home
});