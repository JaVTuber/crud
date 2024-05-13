var x = document.getElementById("fLog");
var y = document.getElementById("fReg");
var z = document.getElementById("btnvai");
var textcolor1=document.getElementById("vaibtnlogin");
var textcolor2=document.getElementById("vaibtnregistrar");
textcolor1.style.color="white";
textcolor2.style.color="#1C1678";

function regis()
{
x.style.left = "-400px";
y.style.left = "50px";
z.style.left = "110px";
textcolor1.style.color="#1C1678";
textcolor2.style.color="white";
}
function login()
{
x.style.left = "50px";
y.style.left = "450px";
z.style.left = "0";
textcolor1.style.color="white";
textcolor2.style.color="#1C1678";
}
