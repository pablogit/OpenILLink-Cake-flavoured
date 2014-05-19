function valueChanged(fieldId)
{
	var field = document.getElementById(fieldId);
	if(field.value == 'new')
	{
		document.getElementById(fieldId + "New").style.display = 'inline-block';
	}
	else
	{
		document.getElementById(fieldId + "New").value = '';
		document.getElementById(fieldId + "New").style.display = 'none';
	}
}

function expand(fieldId)
{
	var field = document.getElementById(fieldId);

	if(!field.hasAttribute('style') || field.style.display == 'none')
		field.style.display = 'block';
	else
		field.style.display = 'none';
}

function deleteCookie(name)
{
	document.cookie = name + "=;path=/;expires=Thu, 01-Jan-70 00:00:01 GMT";
}

function orderCleanup()
{
	document.getElementById('uid').value = '';
	document.getElementById('OrderJournalTitle').value = '';
	document.getElementById('OrderDocType').value = 'article';
	document.getElementById('OrderYear').value = '';
	document.getElementById('OrderVolume').value = '';
	document.getElementById('OrderIssue').value = '';
	document.getElementById('OrderSupplement').value = '';
	document.getElementById('OrderPages').value = '';
	document.getElementById('OrderArticleTitle').value = '';
	document.getElementById('OrderAuthors').value = '';
	document.getElementById('OrderEdition').value = '';
	document.getElementById('OrderIsxn').value = '';
	document.getElementById('OrderUid').value = '';
	document.getElementById('OrderUserComment').value = '';
}

function addField()
{
	var nbChildren = $('#fields').children().length;
	$('#fields').append('<div><label></label><select name="data[Statistics][fields][]">' +
		$('#StatisticsFields').html() + 
		'</select>' + 
		'<input type="hidden" name="data[Statistics][is_count]['+nbChildren+']" value="0"/><input type="checkbox" name="data[Statistics][is_count]['+nbChildren+']" value="1"/></div>'); 
}

function addGroupby()
{
	$('#groupby').append('<div><label></label><select name="data[Statistics][groupby][]">' +
		$('#StatisticsFields').html() + 
		'</select></div>'); 
}

function addCondition()
{
	$('#condition').append('<div><label></label><select name="data[Statistics][conditions][]">' +
		$('#StatisticsFields').html() + 
		'</select>' +
		'<select name="data[Statistics][operators][]">' +
			$('#StatisticsOperator').html() +
		'</select>' +
		'<input type="text" name="data[Statistics][comparators][]">' +
		'</div>'); 
}

function cleanupUid()
{
	document.getElementById('uid').value = document.getElementById('uid').value.replace(/\s+/g,"");
}

function updateFromName()
{
	var id = $('#names').val();
	var row = $('#name'+id);
	$('#OrderSurname').val(row.attr('surname'));
	$('#OrderFirstname').val(row.attr('firstname'));
	$('#OrderServiceId').val(row.attr('service_id'));
	$('#OrderMail').val(row.attr('mail'));
	$('#popUpDiv').hide();
}

function autoFill()
{
	if(navigator.appName == "Microsoft Internet Explorer")
	{
		var WshNetwork = new ActiveXObject("WScript.Network");
		$.ajax({
			async:true, 
			data:"login="+ WshNetwork.UserName, 
			dataType:"html", 
			success:function (data, textStatus) 
				{
					$("#userinfo").html(data);
				}, 
			type:"POST", 
			url:"\/orders\/windowsLoginLookup"});
	}
}