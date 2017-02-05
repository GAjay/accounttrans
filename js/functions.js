//-------------------------------------------------------------------------------------------------------------------------
//-------------------paid user---------------------------------------------
	function paid() {
		document.getElementById('myIframe').src = 'other/paid.php?user='+user+'&perm='+perm;
	};
	function undo_paid(){
		document.getElementById('myIframe').src = 'other/undo_paid.php';
	};
	
	
	function print_value(){
		document.getElementById('myIframe').src = 'other/print_value.php?user='+user+'&perm='+perm;
	};
	function profile(){
		document.getElementById('myIframe').src = 'other/profile.php?user='+user+'&perm='+perm;
	};
	function grn_search(){
		document.getElementById('myIframe').src = 'other/grn_search.php';
	};
//---------------------------------------------------------------------------------------------------------------------------------
//-------------------------admin only-------------------------------------------
	function party() {
		document.getElementById('myIframe').src = 'other/party.php';
	};
	function member() {
		document.getElementById('myIframe').src = 'other/member.php?';
	};
	function payment() {
		document.getElementById('myIframe').src = 'other/payment.php';
	};
	function challan_search(){
		document.getElementById('myIframe').src = 'other/challan_search.php';
	};
	
	
	
	
	function round_of(){
		document.getElementById('myIframe').src = 'other/round_of.php';
	}
	function pakka_challan(){
		document.getElementById('myIframe').src = 'other/pakka_challan.php';
	}
	function monthly_statement(){
		document.getElementById('myIframe').src = 'other/monthly_statement.php';
	}