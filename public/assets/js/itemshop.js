function changePrice(price, id, money)
{
	var buyNum = document.getElementById("itemNum"+id).value;
	document.getElementById("buyPrice"+id).innerHTML = price * buyNum;
	
	document.getElementById("buyResult"+id).innerHTML = money - (price * buyNum);
}