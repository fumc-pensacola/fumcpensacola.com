function addCharge() {
      var myform = document.getElementById('epayform');
	var opfund = myform.OperatingFund.value * 1;
      var desgift = myform.DesignatedGift.value * 1;
      var lt = myform.LivingTrust.value * 1;
      var ph = myform.PHBuildingFund.value * 1;
      var tuition = myform.ChildCareTuition.value * 1;
       var missions = myform.Missions.value * 1;
       var og = myform.OtherGift.value * 1;
       var total = opfund + desgift + lt + ph + tuition + missions + og;
      myform.UMamount.value = CurrencyFormatted(total) ;
      document.getElementById('totalamount').innerHTML = CurrencyFormatted(total) ;
      }

function CreateComments(myform) {
	var opfund = myform.OperatingFund.value * 1;
	var desgift = myform.DesignatedGift.value * 1;
	var lt = myform.LivingTrust.value * 1;
	var ph = myform.PHBuildingFund.value * 1;
	var tuition = myform.ChildCareTuition.value * 1;
	var missions = myform.Missions.value * 1;
	var og = myform.OtherGift.value * 1;
	var comments = 'Operating Fund: ' + CurrencyFormatted(opfund) + ' / ';
	comments = comments + ' Missions: ' + CurrencyFormatted(missions) + ' / '; 
	comments = comments + ' Designated Gift: ' + CurrencyFormatted(desgift) + ' (' + myform.DGDesignee.value + ') / ';
	comments = comments + ' Living Trust: ' + CurrencyFormatted(lt) + ' (' + myform.LTHonoree.value + ') / ';
	comments = comments + ' Perry Home Building: ' + CurrencyFormatted(ph) + ' / ';
	comments = comments + ' Child Care Tuition: ' + CurrencyFormatted(tuition) + ' (' + myform.CCTChildName.value + ') / ';
	comments = comments + ' Other Gift: ' + CurrencyFormatted(og) + ' (' + myform.OGPurpose.value + '}';
	myform.UMcomments.value = comments;
}

function fumcValidateFields(myform) {
	if ((myform.LivingTrust.value*1) > 0 && myform.LTHonoree.value == "") {
		alert("If you have a living trust gift, you must fill in the honoree field.");
		return false;
	}
	if ((myform.DesignatedGift.value*1) > 0 && myform.DGDesignee.value == "") {
		alert("You must provide a designation for your designated gift.");
		return false;
	}
	if ((myform.ChildCareTuition.value*1) > 0 && myform.CCTChildName.value == "") {
		alert("Please provide a name for your tuition payment.");
		return false;
	}
	if ((myform.OtherGift.value*1) > 0 && myform.OGPurpose.value == "") {
		alert("Please provide an explanation for your other payment.");
		return false;
	}
	if ((myform.UMamount.value*1) == 0) {
		alert("Transaction total is $0.00.");
		return false;
	}
	return true;
}

function beforeSubmit(myform) {
	CreateComments(myform);
	return fumcValidateFields(myform);
}

function CurrencyFormatted(amount)
{
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
}
// end of function CurrencyFormatted()

