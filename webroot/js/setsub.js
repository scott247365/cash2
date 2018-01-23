
function setSub(cat, elementId)
{
	//alert(elementId);

	var subs = document.getElementById(elementId);
	
	// clear the dropdown
	var length = subs.options.length;
	if (length > 0)
	{
		for (var i = length - 1; i >= 0; i--) 
			subs.remove(i);
	}
		
	// re-add the none option
	var op = new Option();
	op.text = '(none)';
	op.value = '';	
	subs.options.add(op);
	
	var cat_type = 0;
	for (var j = 0; j < subjump.length; j++)
	{
		if (subjump[j][2] == cat)
		{
			var op = new Option();
			op.text = subjump[j][0];
			op.value = subjump[j][1];
			
			subs.options.add(op);
			
			cat_type = subjump[j][3];
		}
	}
	
	if (subs.options.length > 1)
		subs.selectedIndex = 1;
		
	if (cat_type == 1)
		document.getElementById("TransactionType1").checked = true;
	else if (cat_type == 2)
		document.getElementById("TransactionType2").checked = true;	
}
