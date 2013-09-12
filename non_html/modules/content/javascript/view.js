 $(document).ready(function()
 {
 	view = 0;
    $("#viewadvanced").click(function()
    {
    	if (view == 0)
    	{
   			$("#advanced").slideDown("slow");
   			$("#next-image").hide();
   			$("#up-image").show();
   			view = 1;	
   			return (null);
   		}
   		if (view = 1)
   		{
   			$("#advanced").slideUp("slow");
   			$("#next-image").show();
   			$("#up-image").hide();
   			view = 0;
   			return (null);	
   		}
 	});
 });
 
 
function doAction() 
{ 
	PageIndex=document.getElementById('newlist').selectedIndex;
	if (document.getElementById('newlist').options[PageIndex].value != "none") 
	{ 
		document.getElementById('new').submit();	
	} 
}