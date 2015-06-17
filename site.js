//The primary javascript file for interactive and AJAX content
$(function() {
   //Selectiving Download vs Filters tabs on the Network page.
   $("#filters_btn").on( "click", function() {
   		$("#filters_li").addClass("active");
   		$("#downloads_li").removeClass("active");
   		$("#downloads_panel").hide();
   		$("#filters_panel").show();

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
   		if ($(this).find(".badge").hasClass("bo-pt") || $(this).find(".badge").hasClass("mu-pt") || $(this).find(".badge").hasClass("noch-pt") || $(this).find(".badge").hasClass("gn-pt") || $(this).find(".badge").hasClass("ls-pt")  ){

   			//inactivate
   			$(this).find(".badge").removeClass("bo-pt");
   			$(this).find(".badge").removeClass("mu-pt");
   			$(this).find(".badge").removeClass("noch-pt");
   			$(this).find(".badge").removeClass("gn-pt");
            $(this).find(".badge").removeClass("ls-pt");

   			//If disabling mutant interactions
   			if($(this).hasClass("m-int")){
   				cy.elements("node[mut_type = 'mut']").hide();
   			}
            else if ($(this).hasClass("bo-int")){
               cy.elements("node[mut_type = 'both']").hide();
            }
            else if ($(this).hasClass("gain-int")){
               cy.elements("node[mut_type = 'gain']").hide();
            }
            else if ($(this).hasClass("loss-int")){
               cy.elements("node[mut_type = 'loss']").hide();
            }
            else if ($(this).hasClass("no-int")){
               cy.elements("node[mut_type = 'neutral']").hide();
            }

   		}
   		else{
   			$(this).find(".badge").addClass($(this).find(".badge").data("color"));

   			//If enabling mutant interactions
   			if($(this).hasClass("m-int")){
   				cy.elements("node[mut_type = 'mut']").show();
   			}
            else if ($(this).hasClass("bo-int")){
               cy.elements("node[mut_type = 'both']").show();
            }
            else if ($(this).hasClass("gain-int")){
               cy.elements("node[mut_type = 'gain']").show();
            }
            else if ($(this).hasClass("loss-int")){
               cy.elements("node[mut_type = 'loss']").show();
            }
            else if ($(this).hasClass("no-int")){
               cy.elements("node[mut_type = 'neutral']").show();
            }
   		}
   });

});
