
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>DataGrid Pagination - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<!link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<!link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body>
	<h2>DataGrid Pagination Demo</h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Click the page bar to change page number or page size.</div>
	</div>
	<p>
		Pagination on 
		<select id="p-pos" onchange="changeP()">
			<option>bottom</option>
			<option>top</option>
			<option>both</option>
		</select>
		Style
		<select id="p-style" onchange="changeP()">
			<option>manual</option>
			<option>links</option>
		</select>
	</p>
	
	<table id="tt" class="easyui-datagrid" style="width:700px;height:250px"
			url="get/get_table.php?user=test&perm=1,2,3"
			title="Load Data" iconCls="icon-save"
			rownumbers="true" pagination="true">
		<thead>
			<tr>
				<th field="G.R.No" width="80">G.R.No</th>
				<th field="productid" width="120">Product ID</th>
				<th field="listprice" width="80" align="right">List Price</th>
				<th field="unitcost" width="80" align="right">Unit Cost</th>
				<th field="attr1" width="200">Attribute</th>
				<th field="status" width="60" align="center">Stauts</th>
			</tr>
		</thead>
	</table>
	<script type="text/javascript">
		function changeP(){
			var dg = $('#tt');
			dg.datagrid('loadData',[]);
			dg.datagrid({pagePosition:$('#p-pos').val()});
			dg.datagrid('getPager').pagination({
				layout:['list','sep','first','prev','sep',$('#p-style').val(),'sep','next','last','sep','refresh']
			});
		}
	</script>
</body>
</html>