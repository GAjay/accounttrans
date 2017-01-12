	$(document).ready(function(){
		var count = 0;
		$('#loading').hide();
		$('#grn').keyup(function(){
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
		$('#mrk').keyup(function(){
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
		$('#frght').keyup(function(){
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
//-----------------------------------------------------------------------------
		$('#add').click(function(){
			$('h3').remove();
			$('#loading').show();
			if(count == 0){
				var new_doa = null;
				$('#update').remove();
				$('#paid').remove();
				$('#fn').remove();
				$('#main_table').find('tr').remove();
				html = '<tr><th>G.R.No</th><th>Marka</th><th>Nag</th><th>particular</th><th>weight</th><th>freight</th><th>dateofarrival</th><th>truckno</th><th>drivername</th><th>partyname</th></tr>'
				$('#main_table').append(html);
			}
			else{
				new_doa = $('#'+count+'_dateofarrival').val();
			}
				count++;
			html = '<tr class="js"><td><input type="number" name="'+count+'_g_r_no" ></td>'+
					'<td><input type="text" name="'+count+'_marka"></td>'+
					'<td><input type="number" name="'+count+'_nag"></td>'+
					'<td><input type="text" name="'+count+'_particular"></td>'+
					'<td><input type="text" name="'+count+'_weight"></td>'+
					'<td><input type="text" name="'+count+'_freight"></td>'+
					'<td><input type="date" id="'+count+'_dateofarrival" name="'+count+'_dateofarrival"></td>'+
					'<td><input type="text" name="'+count+'_truckno"></td>'+
					'<td><input type="text" name="'+count+'_drivername"></td>'+
					'<td><input type="text" name="'+count+'_partyname"></td></tr>';
			$('#main_table').append(html);
			if(new_doa != null){
				$('#'+count+'_dateofarrival').val(new_doa);
			}
			else{
				$("#add").html('Add Row');
				$("#upload_record_fild").html('<button id="upload_record_btn" type="submit">Upload Record</button>');
				$("#cancel_fild").html('<button id="cancel_btn" type="submit">Cancel</button>');
			}
			$('#loading').hide();
			$('#upload_record').val(count);
		});
		$("#cancel_fild").click(function(){
			window.location.href = 'home.php?user='+user+'&perm='+perm;
		});
	});