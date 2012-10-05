// JavaScript for Zenphoto theme Killer Bee
function IB_restore() { //v3.0
  var i,x,a=document.IB_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function IB_preload() { //v3.0
  var d=document; if(d.images){ if(!d.IB_p) d.IB_p=new Array();
    var i,j=d.IB_p.length,a=IB_preload.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.IB_p[j]=new Image; d.IB_p[j++].src=a[i];}}
}

function IB_find(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=IB_find(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function IB_swap() { //v3.0
  var i,j=0,x,a=IB_swap.arguments; document.IB_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=IB_find(a[i]))!=null){document.IB_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function toggleComments() {
  var commentDiv = document.getElementById("comments");
  if (commentDiv.style.display == "block") {
    commentDiv.style.display = "none";
  } else {
    commentDiv.style.display = "block";
  }
}
