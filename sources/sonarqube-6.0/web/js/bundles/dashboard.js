webpackJsonp([7],[function(t,e,o){"use strict";function a(t){return t&&t.__esModule?t:{"default":t}}var i=o(354),n=a(i),s=o(328),r=a(s);window.Portal=function(t){this.initialize(t)},window.Portal.prototype={initialize:function(t){this.options=t,this.options.editorEnabled&&(this.createAllSortables(),this.lastSaveString="",this.saveDashboardsState())},createAllSortables:function(){var t=this,e=(0,n["default"])("."+this.options.block),o=(0,n["default"])("."+this.options.columnHandle),a=void 0,i=function(e){(0,n["default"])(e.currentTarget).removeClass(t.options.hoverClass)},s=function(e){e.preventDefault(),a.detach().insertBefore((0,n["default"])(e.currentTarget)),i(e),t.saveDashboardsState()};e.prop("draggable",!0).on("selectstart",function(){return this.dragDrop(),!1}).on("dragstart",function(t){t.originalEvent.dataTransfer.setData("Text","drag"),a=(0,n["default"])(this),o.show()}).on("dragover",function(e){a.prop("id")!==(0,n["default"])(this).prop("id")&&(e.preventDefault(),(0,n["default"])(e.currentTarget).addClass(t.options.hoverClass))}).on("drop",s).on("dragleave",i),o.on("dragover",function(e){e.preventDefault(),(0,n["default"])(e.currentTarget).addClass(t.options.hoverClass)}).on("drop",s).on("dragleave",i)},highlightWidget:function(t){var e=(0,n["default"])("#block_"+t),o=this.options;e.css("background-color",o.highlightStartColor),setTimeout(function(){e.css("background-color",o.highlightEndColor)},this.options.highlightDuration)},saveDashboardsState:function(){var t=this.options,e=(0,n["default"])("."+this.options.column).map(function(){var e=(0,n["default"])(this).find("."+t.block);return(0,n["default"])(this).find("."+t.columnHandle).toggle(0===e.length),e.map(function(){return(0,n["default"])(this).prop("id").substring(t.block.length+1)}).get().join(",")}).get().join(";");if(e!==this.lastSaveString){var o=""===this.lastSaveString;if(this.lastSaveString=e,!o&&this.options.saveUrl){var a=this.options.dashboardState+"="+encodeURIComponent(e);n["default"].ajax({url:this.options.saveUrl,type:"POST",data:a})}}},editWidget:function(t){(0,n["default"])("#widget_title_"+t).hide(),(0,n["default"])("#widget_"+t).hide(),(0,n["default"])("#widget_props_"+t).show(),(0,n["default"])((0,n["default"])("#block_"+t+" a.link-action")[0]).hide()},cancelEditWidget:function(t){(0,n["default"])("widget_title_"+t).show(),(0,n["default"])("#widget_"+t).show(),(0,n["default"])("#widget_props_"+t).hide(),(0,n["default"])((0,n["default"])("#block_"+t+" a.link-action")[0]).show()},deleteWidget:function(t){(0,n["default"])(t).closest("."+this.options.block).remove(),this.saveDashboardsState()}},window.autoResize=function(t,e){var o=r["default"].debounce(e,t);(0,n["default"])(window).on("resize",o)}}]);