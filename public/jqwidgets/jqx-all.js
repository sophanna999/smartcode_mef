/*
jQWidgets v3.9.0 (2015-Oct)
Copyright (c) 2011-2015 jQWidgets.
License: http://jqwidgets.com/license/
*/


f.blur(function(){f.removeClass(I.toThemeProperty("jqx-fill-state-focus"))});
f.keydown(function(K){if(K.keyCode=="13"){I._applyfilterfromfilterrow()}
if(f[0]._writeTimer){
	clearTimeout(f[0]._writeTimer)
}
/* Original
f[0]._writeTimer=setTimeout(function(){
	if(!I._loading){
		if(!I["_oldWriteText"+f[0].id]){
			I["_oldWriteText"+f[0].id]=""
		}
		if(I["_oldWriteText"+f[0].id]!=f.val()){
			I._applyfilterfromfilterrow();
			I["_oldWriteText"+f[0].id]=f.val()
		}
	}
}*/
f[0]._writeTimer=function(){
	if(!I._loading){
		if(!I["_oldWriteText"+f[0].id]){
			I["_oldWriteText"+f[0].id]=""
		}
		if(I["_oldWriteText"+f[0].id]!=f.val()){
			I._applyfilterfromfilterrow();
			I["_oldWriteText"+f[0].id]=f.val()
		}
	}
}
			;