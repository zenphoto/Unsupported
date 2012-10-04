// - - - - - - - - - - JavaScript Document - - - - - - - - - - - - 
//
// Title : Js file	
// Author : Cody Lindley
// URL : www.codylindley.com
//
// Description :
//
// Created : 4/10/06
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//add event function
function addEvent( obj, type, fn ) {
	if (obj.addEventListener) {
		obj.addEventListener( type, fn, false );
		EventCache.add(obj, type, fn);
	}
	else if (obj.attachEvent) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
		EventCache.add(obj, type, fn);
	}
	else {
		obj["on"+type] = obj["e"+type+fn];
	}
}

//remove event function
function removeEvent( obj, type, fn )
{
	EventCache.remove(obj, type, fn);
}

//flush all events on page unload
var EventCache = function()
{
var listEvents = [];
return {
listEvents : listEvents,
add : function(node, sEventName, fHandler)
{
listEvents.push(arguments);
},
remove : function(node, sEventName, fHandler)
{
var i, item;
for(i = listEvents.length - 1; i >= 0; i = i - 1) {
if(node == listEvents[i][0] && sEventName == listEvents[i][1] && fHandler == listEvents[i][2]) {
item = listEvents[i];
if(item[0].removeEventListener) {
item[0].removeEventListener(item[1], item[2], item[3]);
}
if(item[1].substring(0, 2) != "on") {
item[1] = "on" + item[1];
}
if(item[0].detachEvent) {
item[0].detachEvent(item[1], item[0][sEventName+fHandler]);

}
item[0][item[1]] = null;
}
}
},
flush : function()
{
var i, item, eventtype;
for(i = listEvents.length - 1; i >= 0; i = i - 1) {
item = listEvents[i];
if(item[0].removeEventListener) {
item[0].removeEventListener(item[1], item[2], item[3]);
}
eventtype = item[1];
if(item[1].substring(0, 2) != "on") {
item[1] = 'on' + item[1];
}
if(item[0].detachEvent) {
item[0].detachEvent(item[1], item[2]);
item[0].detachEvent(item[1], item[0][eventtype+item[2]]);
}
item[0][item[1]] = null;
}
}
}
}();

//flush'em
addEvent(window,'unload',EventCache.flush);


//adding event functions to specific links using jquery:

// Full expands a tree with a given ID
function expandTree(treeId) {
  var ul = document.getElementById(treeId);
  if (ul == null) { return false; }
  expandCollapseList(ul,nodeOpenClass);
}

// Fully collapses a tree with a given ID
function collapseTree(treeId) {
  var ul = document.getElementById(treeId);
  if (ul == null) { return false; }
  expandCollapseList(ul,nodeClosedClass);
}

function blockEvents(evt) {
		evt = (evt) ? evt : ((window.event) ? window.event : "");
		if(evt.target){
		evt.preventDefault();
		}else{
		evt.returnValue = false;
		}
}

$(document).ready(function(){

$("a.expandAll").click(function(e){expandTree('treemenu1');blockEvents(e);});
$("a.collapseAll").click(function(e){collapseTree('treemenu1');blockEvents(e);});
$("ul.treemenu").find("a").click(function(){$("ul.treemenu").find("a").removeClass("treeMenuFocus");this.className = 'treeMenuFocus'});
$("a.printButton").click(function(e){window.print();blockEvents(e);});

});

