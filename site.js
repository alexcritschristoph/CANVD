//The primary javascript file for interactive and AJAX content
$(function() {
   //Selectiving Download vs Filters tabs on the Network page.
   $("#filters_btn").on( "click", function() {
   		$("#filters_li").addClass("active");
   		$("#downloads_li").removeClass("active");
   		$("#downloads_panel").hide();
   		$("#filters_panel").show();

   });

   //Tissue load more button on network page
   $('body').on( "click", "#tissue-load-more", function() {
         $(".hidden_tr").show();
         $(this).hide()
         $("#tissue-load-less").show();
   });

   $('body').on( "click", "#tissue-load-less", function() {
         $(".hidden_tr").hide();
         $(this).hide()
         $("#tissue-load-more").show();
   });


   
   //Selecting Download button on network page
   $("#downloads_btn").on( "click", function() {
   		$("#downloads_li").addClass("active");
   		$("#filters_li").removeClass("active");
   		$("#filters_panel").hide();
   		$("#downloads_panel").show();
   });

    //Main page browsing tabs
   $("#browse-tabs li a").on( "click", function() {
   		$("#browse-tabs").find("li").removeClass("active");
   		$(this).parent().addClass("active");
   		if($(this).data("tab")=="protein"){
   			$("#protein-table").hide();
   			$("#pwm-table").hide();
   			$("#tissue-table").show();
   		}
   		else if($(this).data("tab")=="cancer"){
   			$("#tissue-table").hide();
   			$("#pwm-table").hide();
   			$("#protein-table").show();
   		}
   		else if($(this).data("tab")=="tumor"){
   			$("#protein-table").hide();
   			$("#tissue-table").hide();
   			$("#pwm-table").show();
   		}
   });

   //Catches when user presses Enter on Search input
   $('#search_input').keypress(function (e) {
	  if (e.which == 13) {
	    $('#search_form').submit();
	    return false;    
	  }
	});

   //For handling the "Show" buttons to show edges / nodes of the network.
   $(".show-item").on( "click", function() {
   		//Check to see if already active
   		if ($(this).find(".badge").hasClass("alert-info") || $(this).find(".badge").hasClass("alert-danger") || $(this).find(".badge").hasClass("alert-success") || $(this).find(".badge").hasClass("alert-warning")  ){
   			//inactivate
   			$(this).find(".badge").removeClass("alert-info");
   			$(this).find(".badge").removeClass("alert-danger");
   			$(this).find(".badge").removeClass("alert-warning");
   			$(this).find(".badge").removeClass("alert-success");

   			//If disabling mutant interactions
   			if($(this).hasClass("m-int")){
   				cy.elements("node[feature = 'mut']").hide();
   			}
            else if ($(this).hasClass("w-int")){
               cy.elements("node[feature = 'wt']").hide();
            }
            else if ($(this).hasClass("gain-int")){
               cy.elements("node[mut_type = 'gain']").hide();
            }
            else if ($(this).hasClass("loss-int")){
               cy.elements("node[mut_type = 'loss']").hide();
            }
            else if ($(this).hasClass("no-int")){
               cy.elements("node[mut_type = 'norm']").hide();
            }

   		}
   		else{
   			$(this).find(".badge").addClass($(this).find(".badge").data("color"));

   			//If enabling mutant interactions
   			if($(this).hasClass("m-int")){
   				cy.elements("node[feature = 'mut']").show();
   			}
            else if ($(this).hasClass("w-int")){
               cy.elements("node[feature = 'wt']").show();
            }
            else if ($(this).hasClass("gain-int")){
               cy.elements("node[mut_type = 'gain']").show();
            }
            else if ($(this).hasClass("loss-int")){
               cy.elements("node[mut_type = 'loss']").show();
            }
            else if ($(this).hasClass("no-int")){
               cy.elements("node[mut_type = 'norm']").show();
            }
   		}
   });

});