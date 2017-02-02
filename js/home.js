	$(document).ready(function(){
		var dataString;	var party_search = "1";	var grn = '';	var mrk=''; var frght=''; var dod='';
		$('#loading').hide();
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
		$('#grn').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			$('#mrk_li_option').find('option').remove();
			grn = $(this).val();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&dod='+dod+'&party='+party_search+'&pakka='+pakka;
			console.log(dataString);
			$.ajax
			({
				type: "POST",
				url: "get/get_marka.php",
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#mrk_li_option').html(data);				
				}
			});
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
			$('#mrk').val(null);
			$('#frght').val(null);
			$('#dod').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------
		$('#mrk').bind('keyup change', function(){
			mrk = $(this).val();
			var dataString;
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
			$('#frght').val(null);
			$('#dod').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------		
		$('#frght').bind('keyup change', function(){
			frght = $(this).val();
			var dataString;
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
			$('#dod').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------
		$('#dod').change(function(){
			if($(this).val()!=''){
			dod = $(this).val().substring(6,8)+"-"+$(this).val().substring(3,5)+"-"+$(this).val().substring(0,2);}else{dod='';}
			console.log(dod);
			var dataString;
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
//-----------------------------------------------------------------------------
	});