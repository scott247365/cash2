function navTo(cat, parms)
{
	//alert(m);
	window.location.href = parms + cat;
}

function navDate(parms, month, year)
{
	//alert(year);
	window.location.href = parms + "&mon=" + month + "&year=" + year;
}