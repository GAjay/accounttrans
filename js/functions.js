	function paid() {
		document.getElementById('myIframe').src = 'other/paid.php?user='+user+'&perm='+perm;
	};
	function print_value(){
		document.getElementById('myIframe').src = 'other/print_value.php?user='+user+'&perm='+perm;
	};
	function profile(){
		document.getElementById('myIframe').src = 'other/profile.php?user='+user+'&perm='+perm;
	};
