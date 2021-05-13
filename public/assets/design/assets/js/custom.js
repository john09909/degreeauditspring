$(document).ready(function() { 
	var base_url = $('#base_url').val();
	var student_id = $('#student_id').val();
	var last_segment = $('#last_segment').val();

	$('body').on('click','.delete_card',function(){
		if(!confirm('are you sure ?')){
			return;
		}

		var _that = $(this);
		//console.log(_that.parent().html());

		var main_div = $(this).parent().attr('data-main');
		var div_type = $(this).parent().attr('data-div');
		var div_id = $(this).parent().attr('data-div-id');
		var page_id = $('#page_id').val();
		var str = $(this).parent().text();
		var lastIndex = str.lastIndexOf(" ");
		current_text = str.substring(0, lastIndex);
		current_text = $.trim(current_text);
		
		var arr = [];
		_that.closest('.mh3').find('div').each(function(){
			str = $(this).text();
			lastIndex = str.lastIndexOf(" ");
			str = str.substring(0, lastIndex);	
			str = $.trim(str);

			if(current_text!=str){
				arr.push(str);
			}
		});

		$.ajax({
		   type: "POST",
		   data: {last_segment:last_segment,student_id:student_id,_token:$('#_token').val(),div_type:div_type,card_element:arr,page_id:page_id,main_div:main_div,div_id:div_id},
		   url: base_url+"save_callback",
		   success: function(msg){
		   		_that.parent().remove();
		   }
		});
	});	

	$('body').on('click','.add_course_top_bar',function(){
		$(this).prev().prev().show();
		$(this).prev().hide();
		$(this).hide();
	});

	$('body').on('click','.add_course_top_bar_in_db',function(){
		var _that = $(this);
		
		var main_div = $(this).closest('.mb1').prev().prev().attr('data-main');
		var div_type = $(this).closest('.mb1').prev().prev().attr('data-div');
		var div_id = $(this).closest(".active").attr('data-div-id');

		var e = $('<div data-main="'+main_div+'" data-div="'+div_type+'" data-div-id="'+div_id+'" class="card mt1 mb0 pa2 move_me" style="cursor: pointer;">'+$(this).prev().val()+' <i class="material-icons delete_card" style="padding-left: 90%;">delete</i></div>');
		$(this).closest('.mb1').prev().prev().append(e); 
		
		console.log(main_div,'main_div',div_type,'div_type',div_id,'div_id');
		
		$(this).closest('.main_div').hide();
		$(this).closest('.main_div').next().show();
		$(this).closest('.main_div').next().next().show();

		if($.trim($(this).prev().val()!="")){
			var arr = [];
			$(this).closest('.pointer').prev().prev().find('div').each(function(){
			  arr.push($(this).text());
			});

			let page_id = $('#page_id').val();

			$.ajax({
			   type: "POST",
			   data: {last_segment:last_segment,student_id:student_id,_token:$('#_token').val(),div_type:div_type,card_element:arr,page_id:page_id,main_div:main_div,div_id:div_id},
			   url: base_url+"save_callback",
			   success: function(msg){
			     _that.prev().val('');
			   }
			});
		}
	});

	$('body').on('click','.add_course_top_bar_in_cancel',function(){
		$(this).closest('.main_div').hide();
		$(this).closest('.main_div').next().show();
		$(this).closest('.main_div').next().next().show();
	});

	$('body').on('click','.add_year',function(){
		let count_div = $(".clone_div_append").find('.active').length;
		let page_id = $('#page_id').val();

		//count_div = parseInt(count_div) + 1;

		$.get(base_url+'max_div_id/'+page_id+'/'+student_id,function(res){
			if(res){
				div_id = parseInt(res.div_id) + 1;
				let clone_div = $(".clone_div").clone();
				$(clone_div).appendTo(".clone_div_append").show().addClass('active').attr('data-div-id',div_id);
				$(clone_div).find('.remove_me').html('<b>Academic year '+res.total+'</b>');
				
				$(clone_div).find('.div_1_dynamic').html('Academic year '+res.div_1_year).removeClass('div_1_dynamic');
				$(clone_div).find('.div_2_dynamic').html('Academic year '+res.div_2_year).removeClass('div_2_dynamic');
				$(clone_div).find('.div_3_dynamic').html('Academic year '+res.div_3_year).removeClass('div_3_dynamic');

				$('.active').removeClass('clone_div');
			}else{
				let clone_div = $(".clone_div").clone();
				$(clone_div).appendTo(".clone_div_append").show().addClass('active').attr('data-div-id',1);
				$(clone_div).find('.remove_me').html('<b>Academic year '+res.total+'</b>')
				
				$(clone_div).find('.div_1_dynamic').html('Academic year '+res.div_1_year).removeClass('div_1_dynamic');
				$(clone_div).find('.div_2_dynamic').html('Academic year '+res.div_2_year).removeClass('div_2_dynamic');
				$(clone_div).find('.div_3_dynamic').html('Academic year '+res.div_3_year).removeClass('div_3_dynamic');


				$('.active').removeClass('clone_div');
			}
		});
	});

	$('body').on('click','.remove_me',function(){
		return;
		let div_id = $(this).closest('.active').attr('data-div-id');
		let page_id = $('#page_id').val();
		var _that = $(this);
		
		if(div_id){
			$.get(base_url+'delete_div/'+div_id+'/'+page_id,function(data){
				if(data){
					_that.closest('.row').remove();
				}else{
					alert('there is something wrong');
				}
			})	
		}
	});

	var getPosition = function(e, ui) {
	  //console.log(e,'e');

  		var statusInfo = function(e, ui) {
      		if(e.type === "sortbeforestop"){
	      		console.log('Piced From');
	      		console.log(e.target.dataset.divId,'divId');
	      		console.log(e.target.dataset.div,'div');

	      		var arr = [];
				$('.mh3[data-div="' + e.target.dataset.div + '"][data-div-id="'+e.target.dataset.divId+'"]').find('div').each(function(){
					if($(this).text()!=""){
						str = $.trim($(this).text());
						lastIndex = str.lastIndexOf(" ");
						str = str.substring(0, lastIndex);	
						str = $.trim(str);
						arr.push(str);	
					}
				});

				//console.log(arr)
				let page_id = 3;				
				//return;
				$.ajax({
				   type: "POST",
				   data: {last_segment:last_segment,student_id:student_id,_token:$('#_token').val(),div_type:e.target.dataset.div,card_element:arr,page_id:page_id,main_div:e.target.dataset.main,div_id:e.target.dataset.divId},
				   url: base_url+"save_callback",
				   success: function(msg){
				     //_that.prev().val('');
				   }
				});
	      	}

        	return "Country now at position " + (ui.item.index() + 1).toString();
  		};

      	var dropPosition = function (e, ui) {
	      	if(e.type === "sortreceive"){
	      		console.log(e,ui)

	      		console.log('Move Successfully');
	      		console.log(e.target.dataset.divId,'divId');
	      		console.log(e.target.dataset.div,'div');
	      		console.log(e.target.dataset.main,'main');

	      		var arr = [];
				$('.mh3[data-div="' + e.target.dataset.div + '"][data-div-id="'+e.target.dataset.divId+'"]').find('div').each(function(){
					if($(this).text()!=""){
						str = $.trim($(this).text());
						lastIndex = str.lastIndexOf(" ");
						str = str.substring(0, lastIndex);	
						str = $.trim(str);
						arr.push(str);		
					}
				});

				
				//MAKE RED LABEL
				let course_id = ui.item[0].innerText.split(' ').slice(0,2).join('').toLowerCase();

				//SAVE MOVE CARD
				let page_id = 3;				
				$.ajax({
				   type: "POST",
				   data: {last_segment:last_segment,student_id:student_id,_token:$('#_token').val(),div_type:e.target.dataset.div,card_element:arr,page_id:page_id,main_div:e.target.dataset.main,div_id:e.target.dataset.divId},
				   url: base_url+"save_callback",
				   success: function(msg){
				     	if(course_id){
			      			$.ajax({
							   type: "POST",
							   data: {_token:$('#_token').val(),course_id:course_id,arr:arr},
							   url: base_url+"red_label_card",
							   success: function(msg){
							     if(msg){
							     	ui.item.css("background", "red");
							     }else{
							     	ui.item.css("background", "");
							     }
							   }
							});
		      			}
				   }
				});
	      	}
       };

      $("#status").remove();
      $("<p />", {
        id: "status",
        text: [ statusInfo(e, ui), dropPosition(e, ui) ].join(" "),
        css: { clear: "both" }
      }).appendTo("body");
    };

	$('.mh3').sortable({
	  connectWith: '.mh3',
	  beforeStop: getPosition,
      receive: getPosition,
	  stop: function() {
	  	console.log($(this).closest('.mh3').attr('div_3'))
	  },
	  update: function(event, ui) {
	    var changedList = this.id;
	    var order = $(this).sortable('toArray');
	    var positions = order.join(';');
	  }
	});
});