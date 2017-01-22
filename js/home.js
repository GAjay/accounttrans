	$(document).ready(function(){
		
		$('#loading').hide();
		$('#grn').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			$('#mrk_li_option').find('option').remove();
			var grn = $(this).val();
			var dataString;
			if(grn!=''){
				dataString = 'gr_no='+grn;
			}
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
			var mrk = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			if($('#grn').val()!=''&& mrk!=''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk;
			}
			else if($('#grn').val()=='' && mrk!=''){
				dataString = 'mrk='+mrk;
			}
			if($('#grn').val()!=''&& mrk==''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn;
			}
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
			var frght = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			if(($('#grn').val()!='')&&($('#mrk').val()!='')&&frght !=''){
				var grn =$('#grn').val();
				var mrk = $('#mrk').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&frght !=''){
				var mrk = $('#mrk').val();
				dataString = 'mrk='+mrk+'&frght='+frght;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&frght !=''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn+'&frght='+frght;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()=='')&&frght !=''){
				dataString = 'frght='+frght;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()!='')&&frght ==''){
				var mrk =$('#mrk').val();
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&frght ==''){
				var mrk =$('#mrk').val();
				dataString = 'mrk='+mrk;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&frght ==''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn;
			}
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
			var doa = $(this).val();
			var dataString;
			$('.j').remove();
			$('#loading').show();
			if(($('#grn').val()!='')&&($('#mrk').val()!='')&&($('#frght').val()!='')&& doa!=''){
				var grn =$('#grn').val();
				var mrk = $('#mrk').val();
				var frght = $('#frght').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght+'&doa='+doa;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&($('#frght').val()!='')&& doa!=''){
				var mrk = $('#mrk').val();
				var frght = $('#frght').val();
				dataString = 'mrk='+mrk+'&frght='+frght+'&doa='+doa;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&($('#frght').val()!='')&& doa!=''){
				var grn =$('#grn').val();
				var frght = $('#frght').val();
				dataString = 'gr_no='+grn+'&frght='+frght+'&doa='+doa;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()!='')&&($('#frght').val()=='')&& doa!=''){
				var grn =$('#grn').val();
				var mrk = $('#mrk').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk+'&doa='+doa;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&($('#frght').val()=='')&& doa!=''){
				var mrk = $('#mrk').val();
				dataString = 'mrk='+mrk+'&doa='+doa;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&($('#frght').val()=='')&& doa!=''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn+'&doa='+doa;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()=='')&&($('#frght').val()!='')&& doa!=''){
				var frght = $('#frght').val();
				dataString = 'frght='+frght+'&doa='+doa;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()=='')&&($('#frght').val()=='')&& doa!=''){
				dataString = 'doa='+doa;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()!='')&&($('#frght').val()!='')&& doa==''){
				var grn =$('#grn').val();
				var mrk = $('#mrk').val();
				var frght = $('#frght').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk+'&frght='+frght;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&($('#frght').val()!='')&& doa==''){
				var mrk = $('#mrk').val();
				var frght = $('#frght').val();
				dataString = 'mrk='+mrk+'&frght='+frght;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&($('#frght').val()!='')&& doa==''){
				var grn =$('#grn').val();
				var frght = $('#frght').val();
				dataString = 'gr_no='+grn+'&frght='+frght;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()=='')&&($('#frght').val()!='')&& doa==''){
				var frght = $('#frght').val();
				dataString = 'frght='+frght;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()!='')&&($('#frght').val()=='')&& doa==''){
				var grn =$('#grn').val();
				var mrk = $('#mrk').val();
				dataString = 'gr_no='+grn+'&mrk='+mrk;
			}
			else if(($('#grn').val()=='')&&($('#mrk').val()!='')&&($('#frght').val()=='')&& doa==''){
				var mrk = $('#mrk').val();
				dataString = 'mrk='+mrk;
			}
			else if(($('#grn').val()!='')&&($('#mrk').val()=='')&&($('#frght').val()=='')&& doa==''){
				var grn =$('#grn').val();
				dataString = 'gr_no='+grn;
			}
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