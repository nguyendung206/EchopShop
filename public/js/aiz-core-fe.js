(()=>{var __webpack_exports__={};$.fn.toggleAttr=function(e,a,t){return this.each((function(){var l=$(this);l.attr(e)==a?l.attr(e,t):l.attr(e,a)}))},function($){"use strict";AIZ.data={csrf:$('meta[name="csrf-token"]').attr("content"),appUrl:$('meta[name="app-url"]').attr("content"),fileBaseUrl:$('meta[name="file-base-url"]').attr("content")},AIZ.uploader={data:{selectedFiles:[],selectedFilesObject:[],clickedForDelete:null,allFiles:[],multiple:!1,type:"all",next_page_url:null,prev_page_url:null},removeInputValue:function(e,a,t){var l=a.filter((function(a){return a!==e}));l.length>0?$(t).find(".file-amount").html(AIZ.uploader.updateFileHtml(l)):t.find(".file-amount").html(AIZ.local.choose_file),$(t).find(".selected-files").val(l)},removeAttachment:function(){$(document).on("click",".remove-attachment",(function(){var e=$(this).closest(".file-preview-item").data("id"),a=$(this).closest(".file-preview").prev('[data-toggle="aizuploader"]').find(".selected-files").val().split(",").map(Number);AIZ.uploader.removeInputValue(e,a,$(this).closest(".file-preview").prev('[data-toggle="aizuploader"]')),$(this).closest(".file-preview-item").remove()}))},deleteUploaderFile:function(){$(".aiz-uploader-delete").each((function(){$(this).on("click",(function(e){e.preventDefault();var a=$(this).data("id");AIZ.uploader.data.clickedForDelete=a,$("#aizUploaderDelete").modal("show"),$(".aiz-uploader-confirmed-delete").on("click",(function(e){if(e.preventDefault(),1===e.detail){var a=AIZ.uploader.data.allFiles[AIZ.uploader.data.allFiles.findIndex((function(e){return e.id===AIZ.uploader.data.clickedForDelete}))];$.ajax({url:AIZ.data.appUrl+"aiz-uploader/destroy/"+AIZ.uploader.data.clickedForDelete,type:"DELETE",dataType:"JSON",data:{id:AIZ.uploader.data.clickedForDelete,_method:"DELETE",_token:AIZ.data.csrf},success:function(){AIZ.uploader.data.selectedFiles=AIZ.uploader.data.selectedFiles.filter((function(e){return e!==AIZ.uploader.data.clickedForDelete})),AIZ.uploader.data.selectedFilesObject=AIZ.uploader.data.selectedFilesObject.filter((function(e){return e!==a})),AIZ.uploader.updateUploaderSelected(),AIZ.uploader.getAllUploads(AIZ.data.appUrl+"aiz-uploader/get_uploaded_files"),AIZ.uploader.data.clickedForDelete=null,$("#aizUploaderDelete").modal("hide")}})}}))}))}))},uploadSelect:function(){$(".aiz-uploader-select").each((function(){var e=$(this);e.on("click",(function(a){var t=$(this).data("value"),l=AIZ.uploader.data.allFiles[AIZ.uploader.data.allFiles.findIndex((function(e){return e.id===t}))];e.closest(".aiz-file-box-wrap").toggleAttr("data-selected","true","false"),AIZ.uploader.data.multiple||e.closest(".aiz-file-box-wrap").siblings().attr("data-selected","false"),AIZ.uploader.data.selectedFiles.includes(t)?(AIZ.uploader.data.selectedFiles=AIZ.uploader.data.selectedFiles.filter((function(e){return e!==t})),AIZ.uploader.data.selectedFilesObject=AIZ.uploader.data.selectedFilesObject.filter((function(e){return e!==l}))):(AIZ.uploader.data.multiple||(AIZ.uploader.data.selectedFiles=[],AIZ.uploader.data.selectedFilesObject=[]),AIZ.uploader.data.selectedFiles.push(t),AIZ.uploader.data.selectedFilesObject.push(l)),AIZ.uploader.addSelectedValue(),AIZ.uploader.updateUploaderSelected()}))}))},updateFileHtml:function(e){var a="";if(e.length>1)a=AIZ.local.files_selected;else a=AIZ.local.file_selected;return e.length+" "+a},updateUploaderSelected:function(){$(".aiz-uploader-selected").html(AIZ.uploader.updateFileHtml(AIZ.uploader.data.selectedFiles))},clearUploaderSelected:function(){$(".aiz-uploader-selected-clear").on("click",(function(){AIZ.uploader.data.selectedFiles=[],AIZ.uploader.addSelectedValue(),AIZ.uploader.addHiddenValue(),AIZ.uploader.resetFilter(),AIZ.uploader.updateUploaderSelected(),AIZ.uploader.updateUploaderFiles()}))},resetFilter:function(){$('[name="aiz-uploader-search"]').val(""),$('[name="aiz-show-selected"]').prop("checked",!1),$('[name="aiz-uploader-sort"] option[value=newest]').prop("selected",!0)},getAllUploads:function(e){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;$(".aiz-uploader-all").html('<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>');var l={};null!=a&&a.length>0&&(l.search=a),null!=t&&t.length>0?l.sort=t:l.sort="newest",$.get(e,l,(function(e,a){"string"==typeof e&&(e=JSON.parse(e)),AIZ.uploader.data.allFiles=e.data,AIZ.uploader.allowedFileType(),AIZ.uploader.addSelectedValue(),AIZ.uploader.addHiddenValue(),AIZ.uploader.updateUploaderFiles(),null!=e.next_page_url?(AIZ.uploader.data.next_page_url=e.next_page_url,$("#uploader_next_btn").removeAttr("disabled")):$("#uploader_next_btn").attr("disabled",!0),null!=e.prev_page_url?(AIZ.uploader.data.prev_page_url=e.prev_page_url,$("#uploader_prev_btn").removeAttr("disabled")):$("#uploader_prev_btn").attr("disabled",!0)}))},showSelectedFiles:function(){$('[name="aiz-show-selected"]').on("change",(function(){$(this).is(":checked")?AIZ.uploader.data.allFiles=AIZ.uploader.data.selectedFilesObject:AIZ.uploader.getAllUploads(AIZ.data.appUrl+"aiz-uploader/get_uploaded_files"),AIZ.uploader.updateUploaderFiles()}))},searchUploaderFiles:function(){$('[name="aiz-uploader-search"]').on("keyup",(function(){var e=$(this).val();AIZ.uploader.getAllUploads(AIZ.data.appUrl+"aiz-uploader/get_uploaded_files",e,$('[name="aiz-uploader-sort"]').val())}))},sortUploaderFiles:function(){$('[name="aiz-uploader-sort"]').on("change",(function(){var e=$(this).val();AIZ.uploader.getAllUploads(AIZ.data.appUrl+"aiz-uploader/get_uploaded_files",$('[name="aiz-uploader-search"]').val(),e)}))},addSelectedValue:function(){for(var e=0;e<AIZ.uploader.data.allFiles.length;e++)AIZ.uploader.data.selectedFiles.includes(AIZ.uploader.data.allFiles[e].id)?AIZ.uploader.data.allFiles[e].selected=!0:AIZ.uploader.data.allFiles[e].selected=!1},addHiddenValue:function(){for(var e=0;e<AIZ.uploader.data.allFiles.length;e++)AIZ.uploader.data.allFiles[e].aria_hidden=!1},allowedFileType:function(){"all"!==AIZ.uploader.data.type&&(AIZ.uploader.data.allFiles=AIZ.uploader.data.allFiles.filter((function(e){return e.type===AIZ.uploader.data.type})))},updateUploaderFiles:function(){$(".aiz-uploader-all").html('<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>');var e=AIZ.uploader.data.allFiles;setTimeout((function(){if($(".aiz-uploader-all").html(null),e.length>0)for(var a=0;a<e.length;a++){var t="";t="image"===e[a].type?'<img src="'+AIZ.data.fileBaseUrl+"/"+e[a].file_name+'" class="img-fit">':'<i class="la la-file-text"></i>';var l='<div class="aiz-file-box-wrap" aria-hidden="'+e[a].aria_hidden+'" data-selected="'+e[a].selected+'"><div class="aiz-file-box"><div class="card card-file aiz-uploader-select" title="'+e[a].file_original_name+"."+e[a].extension+'" data-value="'+e[a].id+'"><div class="card-file-thumb">'+t+'</div><div class="card-body"><h6 class="d-flex"><span class="text-truncate title">'+e[a].file_original_name+'</span><span class="ext">.'+e[a].extension+"</span></h6><p>"+AIZ.extra.bytesToSize(e[a].file_size)+"</p></div></div></div></div>";$(".aiz-uploader-all").append(l)}else $(".aiz-uploader-all").html('<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>No files found</h3></div></div>');AIZ.uploader.uploadSelect(),AIZ.uploader.deleteUploaderFile()}),300)},inputSelectPreviewGenerate:function(e){e.find(".selected-files").val(AIZ.uploader.data.selectedFiles),e.next(".file-preview").html(null),AIZ.uploader.data.selectedFiles.length>0?$.post(AIZ.data.appUrl+"aiz-uploader/get_file_by_ids",{_token:AIZ.data.csrf,ids:AIZ.uploader.data.selectedFiles.toString()},(function(a){if(e.next(".file-preview").html(null),a.length>0){e.find(".file-amount").html(AIZ.uploader.updateFileHtml(a));for(var t=0;t<a.length;t++){var l="";l="image"===a[t].type?'<img src="'+AIZ.data.fileBaseUrl+"/"+a[t].file_name+'" class="img-fit">':'<i class="la la-file-text"></i>';var i='<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="'+a[t].id+'" title="'+a[t].file_original_name+"."+a[t].extension+'"><div class="align-items-center align-self-stretch d-flex justify-content-center thumb">'+l+'</div><div class="col body"><h6 class="d-flex"><span class="text-truncate title">'+a[t].file_original_name+'</span><span class="ext">.'+a[t].extension+"</span></h6><p>"+AIZ.extra.bytesToSize(a[t].file_size)+'</p></div><div class="remove"><button class="btn btn-sm btn-link remove-attachment" type="button"><i class="la la-close"></i></button></div></div>';e.next(".file-preview").append(i)}}else e.find(".file-amount").html(AIZ.local.choose_file)})):e.find(".file-amount").html(AIZ.local.choose_file)},editorImageGenerate:function(e){if(AIZ.uploader.data.selectedFiles.length>0)for(var a=0;a<AIZ.uploader.data.selectedFiles.length;a++){var t=AIZ.uploader.data.allFiles.findIndex((function(e){return e.id===AIZ.uploader.data.selectedFiles[a]})),l="";"image"===AIZ.uploader.data.allFiles[t].type&&(l='<img src="'+AIZ.data.fileBaseUrl+AIZ.uploader.data.allFiles[t].file_name+'">',e[0].insertHTML(l))}},dismissUploader:function(){$("#aizUploaderModal").on("hidden.bs.modal",(function(){$(".aiz-uploader-backdrop").remove(),$("#aizUploaderModal").remove()}))},trigger:function(){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"",t=arguments.length>5&&void 0!==arguments[5]?arguments[5]:null;return function(l,i,o){l=$(l);var n=a;AIZ.uploader.data.selectedFiles=""!==n?n.split(",").map(Number):[],void 0!==i&&i.length>0&&(AIZ.uploader.data.type=i),o&&(AIZ.uploader.data.multiple=o),$.post(AIZ.data.appUrl+"aiz-uploader",{_token:AIZ.data.csrf},(function(a){$("body").append(a),$("#aizUploaderModal").modal("show"),AIZ.plugins.aizUppy(),AIZ.uploader.getAllUploads(AIZ.data.appUrl+"aiz-uploader/get_uploaded_files",null,$('[name="aiz-uploader-sort"]').val()),AIZ.uploader.updateUploaderSelected(),AIZ.uploader.clearUploaderSelected(),AIZ.uploader.sortUploaderFiles(),AIZ.uploader.searchUploaderFiles(),AIZ.uploader.showSelectedFiles(),AIZ.uploader.dismissUploader(),$("#uploader_next_btn").on("click",(function(){null!=AIZ.uploader.data.next_page_url&&($('[name="aiz-show-selected"]').prop("checked",!1),AIZ.uploader.getAllUploads(AIZ.uploader.data.next_page_url))})),$("#uploader_prev_btn").on("click",(function(){null!=AIZ.uploader.data.prev_page_url&&($('[name="aiz-show-selected"]').prop("checked",!1),AIZ.uploader.getAllUploads(AIZ.uploader.data.prev_page_url))})),$(".aiz-uploader-search i").on("click",(function(){$(this).parent().toggleClass("open")})),$('[data-toggle="aizUploaderAddSelected"]').on("click",(function(){"input"===e?AIZ.uploader.inputSelectPreviewGenerate(l):"direct"===e&&t(AIZ.uploader.data.selectedFiles),$("#aizUploaderModal").modal("hide")}))}))}(arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,arguments.length>2&&void 0!==arguments[2]?arguments[2]:"all",arguments.length>4&&void 0!==arguments[4]&&arguments[4])},initForInput:function(){$(document).on("click",'[data-toggle="aizuploader"]',(function(e){if(1===e.detail){var a=$(this),t=a.data("multiple"),l=a.data("type"),i=a.find(".selected-files").val();t=t||"",l=l||"",i=i||"",AIZ.uploader.trigger(this,"input",l,i,t)}}))},previewGenerate:function(){$('[data-toggle="aizuploader"]').each((function(){var e=$(this),a=e.find(".selected-files").val();$.post(AIZ.data.appUrl+"aiz-uploader/get_file_by_ids",{_token:AIZ.data.csrf,ids:a},(function(a){if(e.next(".file-preview").html(null),a.length>0){e.find(".file-amount").html(AIZ.uploader.updateFileHtml(a));for(var t=0;t<a.length;t++){var l="";l="image"===a[t].type?'<img src="'+AIZ.data.fileBaseUrl+"/"+a[t].file_name+'" class="img-fit">':'<i class="la la-file-text"></i>';var i='<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="'+a[t].id+'" title="'+a[t].file_original_name+"."+a[t].extension+'"><div class="align-items-center align-self-stretch d-flex justify-content-center thumb">'+l+'</div><div class="col body"><h6 class="d-flex"><span class="text-truncate title">'+a[t].file_original_name+'</span><span class="ext">.'+a[t].extension+"</span></h6><p>"+AIZ.extra.bytesToSize(a[t].file_size)+'</p></div><div class="remove"><button class="btn btn-sm btn-link remove-attachment" type="button"><i class="la la-close"></i></button></div></div>';e.next(".file-preview").append(i)}}else e.find(".file-amount").html(AIZ.local.choose_file)}))}))}},AIZ.plugins={bootstrapSelect:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";$(".aiz-selectpicker").each((function(a){var t=$(this);if(!t.parent().hasClass("bootstrap-select")){var l=t.data("selected");void 0!==l&&t.val(l),t.selectpicker({size:5,virtualScroll:!1})}"refresh"===e&&t.selectpicker("refresh"),"destroy"===e&&t.selectpicker("destroy")}))},tagify:function tagify(){$(".aiz-tag-input").not(".tagify").each((function(){var $this=$(this),maxTags=$this.data("max-tags"),whitelist=$this.data("whitelist"),onchange=$this.data("on-change");maxTags=maxTags||1/0,whitelist=whitelist||[],$this.tagify({maxTags,whitelist,dropdown:{enabled:1}});try{callback=eval(onchange)}catch(e){var callback=""}"function"==typeof callback&&($this.on("removeTag",(function(){callback()})),$this.on("add",(function(){callback()})))}))},fooTable:function(){$(".aiz-table").each((function(){var e=$(this),a=e.data("empty");a=a||AIZ.local.nothing_found,e.footable({breakpoints:{xs:576,sm:768,md:992,lg:1200,xl:1400},cascade:!0,on:{"ready.ft.table":function(e,a){AIZ.extra.deleteConfirm(),AIZ.plugins.bootstrapSelect("refresh")}},empty:a})}))},notify:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"dark",a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";$.notify({message:a},{showProgressbar:!0,delay:2500,mouse_over:"pause",placement:{from:"bottom",align:"left"},animate:{enter:"animated fadeInUp",exit:"animated fadeOutDown"},type:e,template:'<div data-notify="container" class="aiz-notify alert alert-{0}" role="alert"><button type="button" aria-hidden="true" data-notify="dismiss" class="close"><img src="/assets/img/icons/Group 2338.png" alt=""></button><span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div></div>'})},tooltip:function(){$("body").tooltip({selector:'[data-toggle="tooltip"]'}).click((function(){$('[data-toggle="tooltip"]').tooltip("hide")}))},slickCarousel:function(){$(".aiz-carousel").not(".slick-initialized").each((function(){var e=$(this),a=!1,t=e.data("xs-items"),l=e.data("sm-items"),i=e.data("md-items"),o=e.data("lg-items"),n=e.data("xl-items"),s=e.data("items"),d=e.data("center"),r=e.data("arrows"),c=e.data("dots"),u=e.data("rows"),p=e.data("autoplay"),f=e.data("fade"),h=e.data("nav-for"),v=e.data("infinite"),m=e.data("focus-select"),g=e.data("auto-height"),A=e.data("vertical"),I=e.data("vertical-xs"),Z=e.data("vertical-sm"),b=e.data("vertical-md"),x=e.data("vertical-lg"),k=e.data("vertical-xl");s=s||1,n=n||s,o=o||n,i=i||o,l=l||i,t=t||l,A=A||!1,k=void 0===k?A:k,x=void 0===x?k:x,b=void 0===b?x:b,Z=void 0===Z?b:Z,I=void 0===I?Z:I,d=d||!1,r=r||!1,c=c||!1,u=u||1,p=p||!1,f=f||!1,h=h||null,v=v||!1,m=m||!1,g=g||!1,"rtl"===$("html").attr("dir")&&(a=!0),e.slick({slidesToShow:s,autoplay:p,dots:c,arrows:r,infinite:v,vertical:A,rtl:a,rows:u,centerPadding:"0px",centerMode:d,fade:f,asNavFor:h,focusOnSelect:m,adaptiveHeight:g,slidesToScroll:1,prevArrow:'<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',nextArrow:'<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',responsive:[{breakpoint:1500,settings:{slidesToShow:n,vertical:k}},{breakpoint:1200,settings:{slidesToShow:o,vertical:x}},{breakpoint:992,settings:{slidesToShow:i,vertical:b}},{breakpoint:768,settings:{slidesToShow:l,vertical:Z}},{breakpoint:576,settings:{slidesToShow:t,vertical:I}}]})}))}},AIZ.extra={refreshToken:function(){$.get(AIZ.data.appUrl+"/refresh-csrf").done((function(e){AIZ.data.csrf=e}))},mobileNavToggle:function(){$('[data-toggle="aiz-mobile-nav"]').on("click",(function(){$(".aiz-sidebar-wrap").hasClass("open")?$(".aiz-sidebar-wrap").removeClass("open"):$(".aiz-sidebar-wrap").addClass("open")})),$(".aiz-sidebar-overlay").on("click",(function(){$(".aiz-sidebar-wrap").removeClass("open")}))},initActiveMenu:function(){$('[data-toggle="aiz-side-menu"] a').each((function(){var e=window.location.href.split(/[?#]/)[0];(this.href==e||$(this).hasClass("active"))&&($(this).addClass("active"),$(this).closest(".aiz-side-nav-item").addClass("mm-active"),$(this).closest(".level-2").siblings("a").addClass("level-2-active"),$(this).closest(".level-3").siblings("a").addClass("level-3-active"))}))},deleteConfirm:function(){$(".confirm-delete").click((function(e){e.preventDefault();var a=$(this).data("href");$("#delete-modal").modal("show"),$("#delete-link").attr("href",a)})),$(".confirm-cancel").click((function(e){e.preventDefault();var a=$(this).data("href");$("#cancel-modal").modal("show"),$("#cancel-link").attr("href",a)})),$(".confirm-complete").click((function(e){e.preventDefault();var a=$(this).data("href");$("#complete-modal").modal("show"),$("#comfirm-link").attr("href",a)})),$(".confirm-alert").click((function(e){e.preventDefault();var a=$(this).data("href"),t=$(this).data("target");$(t).modal("show"),$(t).find(".comfirm-link").attr("href",a),$("#comfirm-link").attr("href",a)}))},bytesToSize:function(e){if(0==e)return"0 Byte";var a=parseInt(Math.floor(Math.log(e)/Math.log(1024)));return Math.round(e/Math.pow(1024,a),2)+" "+["Bytes","KB","MB","GB","TB"][a]},multiModal:function(){$(document).on("show.bs.modal",".modal",(function(e){var a=1040+10*$(".modal:visible").length;$(this).css("z-index",a),setTimeout((function(){$(".modal-backdrop").not(".modal-stack").css("z-index",a-1).addClass("modal-stack")}),0)})),$(document).on("hidden.bs.modal",(function(){$(".modal.show").length>0&&$("body").addClass("modal-open")}))},bsCustomFile:function(){$(".custom-file input").change((function(e){for(var a=[],t=0;t<$(this)[0].files.length;t++)a.push($(this)[0].files[t].name);1===a.length?$(this).next(".custom-file-name").html(a[0]):a.length>1?$(this).next(".custom-file-name").html(a.length+" "+AIZ.local.files_selected):$(this).next(".custom-file-name").html(AIZ.local.choose_file)}))},stopPropagation:function(){$(document).on("click",".stop-propagation",(function(e){e.stopPropagation()}))},outsideClickHide:function(){$(document).on("click",(function(e){$(".document-click-d-none").addClass("d-none")}))},inputRating:function(){$(".rating-input").each((function(){$(this).find("label").on({mouseover:function(e){$(this).find("i").addClass("hover"),$(this).prevAll().find("i").addClass("hover")},mouseleave:function(e){$(this).find("i").removeClass("hover"),$(this).prevAll().find("i").removeClass("hover")},click:function(e){$(this).siblings().find("i").removeClass("active"),$(this).find("i").addClass("active"),$(this).prevAll().find("i").addClass("active")}}),$(this).find("input").is(":checked")&&($(this).find("label").siblings().find("i").removeClass("active"),$(this).find("input:checked").closest("label").find("i").addClass("active"),$(this).find("input:checked").closest("label").prevAll().find("i").addClass("active"))}))},scrollToBottom:function(){$(".scroll-to-btm").each((function(e,a){a.scrollTop=a.scrollHeight}))},classToggle:function(){$(document).on("click",'[data-toggle="class-toggle"]',(function(){var e=$(this),a=e.data("target"),t=e.data("same");$(a).hasClass("active")?($(a).removeClass("active"),$(t).removeClass("active"),e.removeClass("active")):($(a).addClass("active"),e.addClass("active"))}))},collapseSidebar:function(){$(document).on("click",'[data-toggle="collapse-sidebar"]',(function(a,t){var l=$(this),i=$(this).data("target"),o=$(this).data("siblings");e.preventDefault(),$(i).hasClass("opened")?($(i).removeClass("opened"),$(o).removeClass("opened"),$(l).removeClass("opened")):($(i).addClass("opened"),$(l).addClass("opened"))}))},autoScroll:function(){$(".aiz-auto-scroll").length>0&&$(".aiz-auto-scroll").each((function(){var e=$(this).data("options");e=e||'{"delay" : 2000 ,"amount" : 70 }',e=JSON.parse(e),this.delay=parseInt(e.delay)||2e3,this.amount=parseInt(e.amount)||70,this.autoScroll=$(this),this.iScrollHeight=this.autoScroll.prop("scrollHeight"),this.iScrollTop=this.autoScroll.prop("scrollTop"),this.iHeight=this.autoScroll.height();var a=this;this.timerId=setInterval((function(){a.iScrollTop+a.iHeight<a.iScrollHeight?(a.iScrollTop=a.autoScroll.prop("scrollTop"),a.iScrollTop+=a.amount,a.autoScroll.animate({scrollTop:a.iScrollTop},"slow","linear")):(a.iScrollTop-=a.iScrollTop,a.autoScroll.animate({scrollTop:"0px"},"fast","swing"))}),a.delay)}))},addMore:function(){$('[data-toggle="add-more"]').each((function(){var e=$(this),a=e.data("content"),t=e.data("target");e.on("click",(function(e){e.preventDefault(),$(t).append(a),AIZ.plugins.bootstrapSelect()}))}))},removeParent:function(){$(document).on("click",'[data-toggle="remove-parent"]',(function(){var e=$(this),a=e.data("parent");e.closest(a).remove()}))},selectHideShow:function(){$('[data-show="selectShow"]').each((function(){var e=$(this).data("target");$(this).on("change",(function(){var a=$(this).val();$(e).children().not("."+a).addClass("d-none"),$(e).find("."+a).removeClass("d-none")}))}))},plusMinus:function(){$(".aiz-plus-minus button").on("click",(function(e){e.preventDefault();var a=$(this).attr("data-field"),t=$(this).attr("data-type"),l=$("input[name='"+a+"']"),i=parseInt(l.val());isNaN(i)?l.val(0):"minus"==t?(i>l.attr("min")&&l.val(i-1).change(),parseInt(l.val())==l.attr("min")&&$(this).attr("disabled",!0)):"plus"==t&&(i<l.attr("max")&&l.val(i+1).change(),parseInt(l.val())==l.attr("max")&&$(this).attr("disabled",!0))})),$(".aiz-plus-minus input").on("change",(function(){var e=parseInt($(this).attr("min")),a=parseInt($(this).attr("max")),t=parseInt($(this).val());name=$(this).attr("name"),t>=e?$(this).siblings("[data-type='minus']").removeAttr("disabled"):(alert("Sorry, the minimum value was reached"),$(this).val($(this).data("oldValue"))),t<=a?$(this).siblings("[data-type='plus']").removeAttr("disabled"):(alert("Sorry, the maximum value was reached"),$(this).val($(this).data("oldValue")))}))},hovCategoryMenu:function(){$("#category-menu-icon, #category-sidebar").on("mouseover",(function(e){$("#hover-category-menu").addClass("active").removeClass("d-none")})).on("mouseout",(function(e){$("#hover-category-menu").addClass("d-none").removeClass("active")}))},setCookie:function(e,a,t){var l=new Date;l.setTime(l.getTime()+24*t*60*60*1e3);var i="expires="+l.toUTCString();document.cookie=e+"="+a+";"+i+";path=/"},getCookie:function(e){for(var a=e+"=",t=decodeURIComponent(document.cookie).split(";"),l=0;l<t.length;l++){for(var i=t[l];" "===i.charAt(0);)i=i.substring(1);if(0===i.indexOf(a))return i.substring(a.length,i.length)}return""},acceptCookie:function(){AIZ.extra.getCookie("acceptCookies")||$(".aiz-cookie-alert").addClass("show"),$(".aiz-cookie-accepet").on("click",(function(){AIZ.extra.setCookie("acceptCookies",!0,60),$(".aiz-cookie-alert").removeClass("show")}))}},setInterval((function(){AIZ.extra.refreshToken()}),36e5),AIZ.extra.initActiveMenu(),AIZ.extra.mobileNavToggle(),AIZ.extra.deleteConfirm(),AIZ.extra.multiModal(),AIZ.extra.inputRating(),AIZ.extra.bsCustomFile(),AIZ.extra.stopPropagation(),AIZ.extra.outsideClickHide(),AIZ.extra.scrollToBottom(),AIZ.extra.classToggle(),AIZ.extra.collapseSidebar(),AIZ.extra.autoScroll(),AIZ.extra.addMore(),AIZ.extra.removeParent(),AIZ.extra.selectHideShow(),AIZ.extra.plusMinus(),AIZ.extra.hovCategoryMenu(),AIZ.extra.acceptCookie(),AIZ.plugins.bootstrapSelect(),AIZ.plugins.tagify(),AIZ.plugins.tooltip(),AIZ.plugins.fooTable(),AIZ.plugins.slickCarousel(),AIZ.uploader.initForInput(),AIZ.uploader.removeAttachment(),AIZ.uploader.previewGenerate()}(jQuery)})();