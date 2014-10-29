<!-- 
<html>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<body>
	
	
		<script>
		function normal()
		{
			
		  		
			    var tagHtml  = '22222sdfsdfskldjfhsdofhewthegohsdlgsghg2';

			    $('body').append(tagHtml);

		
		}
		$(document).ready(function() 
		{		
			  	normal();
			  	var printType = <?php echo $_POST['printType'] ?>;
			  	console.log(printType);


				setTimeout(function()
		    	{
		    		if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
		    		{ 
					    window.PPClose = false;                                   
					    window.onbeforeunload = function()
					    {                         
					        if(window.PPClose === false)
					        {
					            return 'กรุณากด "ยกเลิก" ก่อนออกจากหน้านี้\n';
					        	
					        }
					    }                   
					    window.print();                                           
					    window.PPClose = true;
					}
					else
		    			window.print()
		    	},1000); 
		
		});
		</script>
	</body>
</html> -->