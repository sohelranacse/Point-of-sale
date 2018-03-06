<?php if (1)
{
?>
<script type="text/javascript">



$(window).load(function()
{
	alert('ok');
	
	
		// install firefox addon in order to use this plugin
		if (window.jsPrintSetup) 
		{
			
		// jsPrintSetup.setPrinter('PDFCreator');
			// var oldShowPrintProgress = jsPrintSetup. getShowPrintProgress();
			//jsPrintSetup.setOption('marginTop',20);
			//jsPrintSetup.setOption('marginBottom', 15);
			//jsPrintSetup.setOption('marginLeft', 20);
		//jsPrintSetup.setOption('marginRight', 10);jsPrintSetup.setOption('marginTop', 15);
		//jsPrintSetup.setOption('marginBottom', 15);
		//jsPrintSetup.setOption('marginLeft', 20);
		//jsPrintSetup.setOption('marginRight', 10);
		
		jsPrintSetup.setOption('headerStrLeft','');
jsPrintSetup.setOption('headerStrCenter', 'Yes Enterprise');
jsPrintSetup.setOption('headerStrRight', '');

	jsPrintSetup.setOption('footerStrLeft', '');
jsPrintSetup.setOption('footerStrCenter', 'CursorBd');
jsPrintSetup.setOption('footerStrRight', '');	
	// jsPrintSetup.printWindow(window);	

	//(JSPrintSetup add ons firefox)
	
	var printers = jsPrintSetup.getPrintersList().split(',');
	
	for(var index in printers) {
	jsPrintSetup.clearSilentPrint();
	jsPrintSetup.setOption('printSilent', 1);
	jsPrintSetup.print();
	
	}
	
	///jsPrintSetup.setSilentPrint(true);
//jsPrintSetup.setOption('printSilent', 10);
					//jsPrintSetup.print();
		//jsPrintSetup. setShowPrintProgress(oldShowPrintProgress);
		}
		else
		{
			window.print();
		}
		
		
		
		//window.location="http://localhost/ospos/index.php/sales";
		
		
	
});
</script>
<?php
}

?>