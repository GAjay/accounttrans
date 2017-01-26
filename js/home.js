	$(document).ready(function(){
		var dataString;	var party_search = "default";	var grn = '';	var mrk=''; var frght=''; var doa='';
		$('#loading').hide();
		$('#party_search').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			party_search = $(this).val();
			
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa+'&party='+party_search;
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
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa+'&party='+party_search;
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
			$('#doa').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------
		$('#mrk').bind('keyup change', function(){
			mrk = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa+'&party='+party_search;
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
			$('#doa').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------		
		$('#frght').bind('keyup change', function(){
			frght = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa+'&party='+party_search;
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
			$('#doa').val(null);
		});
//--------------------------------------------------------------------------------		
//---------------------------------------------------------------------------------
		$('#doa').change(function(){
			doa = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa+'&party='+party_search;
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