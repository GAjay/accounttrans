	$(document).ready(function(){
		var dataString;	var party_search = "1";	var grn = '';	var mrk=''; var frght=''; var dod='';
		$('#loading').hide();
//----------------------------------------------------------------------------------------------------------
//--------------------------------------------Party Search-----------------------------------------------
		$('#party_search').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			party_search = $(this).val();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
//----------------------------------------------------------------------------------------------------------
//--------------------------------------------GRN Search-----------------------------------------------
		$('#grn').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			grn = $(this).val();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
//----------------------------------------------------------------------------------------------------------
//--------------------------------------------Marka Search-----------------------------------------------
		$('#mrk').bind('keyup change', function(){
			mrk = $(this).val();
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
//----------------------------------------------------------------------------------------------------------
//--------------------------------------------DOD Search-----------------------------------------------	

		$('#dod').change(function(){
			if($(this).val()!=''){
			dod = $(this).val().substring(6,8)+"-"+$(this).val().substring(3,5)+"-"+$(this).val().substring(0,2);}else{dod='';}
			console.log(dod);
			
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
//----------------------------------------------------------------------------------------------------------

//--------------------------------------------All Field Editable-----------------------------------------------
		$('#all_edit_btn').click(function(){
			$("#left").remove();
			$('#main').css("width", "100%");
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_edit_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
	});
