"use strict";
function reloadTable(data){
   let table=$('.'+data).DataTable();
    table.ajax.reload(null,false);

}
function destroyModal(modalClass=null){
    $(modalClass).iziModal('destroy');
}
function createModal(modalClass = null, modalTitle = null, modalSubTitle = null, width = 800, bodyOverflow = true, padding = "20px", radius = "2px", headerColor = "#448aff", onOpening = function () { }, onOpened = function () { }, onClosing = function () { }, onClosed = function () { }, afterRender = function () { }, onFullScreen = function () { }, onResize = function () { }, fullscreen = true, openFullscreen = false, closeOnEscape = true, closeButton = true, overlayClose = true, autoOpen = 0, zindex = 99999) {
    if (modalClass !== "" || modalClass !== null) {
        $(modalClass).iziModal({
            title: modalTitle,
            subtitle: modalSubTitle,
            headerColor: headerColor,
            width: width,
            zindex: zindex,
            borderBottom: false,
            fullscreen: fullscreen,
            openFullscreen: openFullscreen,
            closeOnEscape: closeOnEscape,
            closeButton: closeButton,
            overlayClose: overlayClose,
            autoOpen: autoOpen,
            padding: padding,
            bodyOverflow: bodyOverflow,
            radius: radius,
            onFullScreen: onFullScreen,
            onResize: onResize,
            onOpening: onOpening,
            onOpened: onOpened,
            onClosing: onClosing,
            onClosed: onClosed,
            afterRender: afterRender
        });
    }
}

function openModal(modalClass = null, event = function () { }) {
    $(modalClass).iziModal('open', event);
}

function closeModal(modalClass = null, event = function () { }) {
    $(modalClass).iziModal('close', event);
}
function inputRender()
{
    $('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').each(function (element, i) {
        if ((i.value !== undefined && i.value!=="" && i.value!==null) ) {
            $(this).parent().find("label").addClass('active');
            $(this).addClass('fill');
        }
        else {
            $(this).parent().find("label").removeClass('active');
            $(this).removeClass('fill');
        }
    });
}
$(document).ready(function () {
    $(document).on("click","#content-submit",function (){
        let title=$("#content-form").find('input[name="title"]').val();
        let description=$("#content-form").find('textarea[name="description"]').val();
        let url=($("#content-form").attr("action"))
        $.ajax({
            dataType: "json",
            type:"POST",
            data:{"title":title,"description":description},
            url:url
        }).done(function (response){
            if(!response.success){
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }else{
                iziToast.success({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
                reloadTable("data-table")
                closeModal("#content-modal")
            }
        })

    })
    $('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').each(function (element, i) {
        if ((i.value !== undefined && i.value!=="" && i.value!==null) ) {
            $(this).parent().find("label").addClass('active');
            $(this).addClass('fill');
        }
        else {
            $(this).parent().find("label").removeClass('active');
            $(this).removeClass('fill');
        }
    });
    /** Dropzone */
    if ($(".dropzone").length > 0) {
        Dropzone.autoDiscover = false;
        //;
        $('.dropzone').each(function(index) {
            let elem = "#" + $(this).attr("id");
            let $uploadSection = Dropzone.forElement(elem);
            $uploadSection.on("complete", function(file) {
                let dataTable = $(elem).data("table");
                reloadTable(dataTable);
            });
        });
    }
    /** Dropzone */
    $(document).on("click",".edit-item",function (){
       let url=$(this).data("url");
       $.ajax({
           dataType: "json",
           url:url
       }).done(function (response){
            if(!response.success){
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }else if(response.success==="render"){
                $("#content-modal").html(response.data);

                destroyModal("#content-modal")
                createModal("#content-modal",response.title,response.subtitle)
                inputRender();
                TinyMCEInit();
                openModal("#content-modal")
            }
       })
    })

    $(document).on("click",".delete-item",function (){
        let id= $(this).data("id");
        let url= $(this).data("url");
        Swal.fire({
            title: 'Silmek İstediğinize Emin misiniz?',
            text: "Bu Kaydı Silerseniz Kayıt Tekrar Geri Getirilemez",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'İptal Et',
            confirmButtonText: 'Evet, Sil'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:url,
                    data:{"id":id},
                    dataType:"json",
                    type:"POST"
                }).done(function (response){
                    if(response.success){
                        $('.data-table').DataTable().ajax.reload()
                        Swal.fire({
                                title: response.title,
                                text: response.msg,
                                icon: 'success',
                                confirmButtonText: 'Kapat'
                            })
                    }else{
                        Swal.fire({
                                title: response.title,
                                text: response.msg,
                                icon: 'error',
                                confirmButtonText: 'Kapat'
                            })
                    }
                })

            }
        })

    })

    TinyMCEInit();
    bs_input_file();


    $(document).on("click", ".isActive", function () {
        let data = $(this).data("id");
        let data_url = $(this).data("url");
        $.ajax({
            type: "POST",
            data: {"id":data},
            url: data_url
        }).done(function (response) {
            if (response.success) {
                iziToast.success({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            } else {
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }
        })

    })
    $(document).on("click", ".isHome", function () {
        let data = $(this).data("id");
        let data_url = $(this).data("url");
        $.ajax({
            type: "POST",
            data: {"id":data},
            url: data_url
        }).done(function (response) {
            if (response.success) {
                iziToast.success({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            } else {
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }
        })

    })
    $(document).on("click", ".isDiscount", function () {
        let data = $(this).data("id");
        let data_url = $(this).data("url");
        $.ajax({
            type: "POST",
            data: {"id":data},
            url: data_url
        }).done(function (response) {
            if (response.success) {
                iziToast.success({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            } else {
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }
        })

    })
    $(document).on("click", ".isCover", function () {
        let data = $(this).data("id");
        let data_url = $(this).data("url");
        $.ajax({
            type: "POST",
            data: {"id":data},
            url: data_url
        }).done(function (response) {
            if (response.success) {
                iziToast.success({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
                reloadTable("data-table")
            } else {
                iziToast.error({
                    title: response.title,
                    message: response.msg,
                    position: "topCenter"
                })
            }
        })

    })
    // card js start
    $(".card-header-right .close-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function () {
            $this.parents('.card').remove();
        }, 800);
    });
    $(".card-header-right .reload-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="fa fa-circle-o-notch rotate-refresh"></div>');
        setTimeout(function () {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    $(".card-header-right .card-option .open-card-option").on('click', function () {
        var $this = $(this);
        if ($this.hasClass('fa-times')) {
            $this.parents('.card-option').animate({
                'width': '30px',
            });
            $(this).removeClass("fa-times").fadeIn('slow');
            $(this).addClass("fa-wrench").fadeIn('slow');
        } else {
            $this.parents('.card-option').animate({
                'width': '140px',
            });
            $(this).addClass("fa-times").fadeIn('slow');
            $(this).removeClass("fa-wrench").fadeIn('slow');
        }
    });
    $(".card-header-right .minimize-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("fa-minus").fadeIn('slow');
        $(this).toggleClass("fa-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("fa-window-restore");
    });
    $("#more-details").on('click', function () {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function () {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    $(".search-btn").on('click', function () {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function () {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function () {
            $(".main-search").removeClass('open');
        }, 300);
    });
    $(document).ready(function () {
        $(".header-notification").click(function () {
            $(this).find(".show-notification").slideToggle(500);
            $(this).toggleClass('active');
        });
    });
    $(document).on("click", function (event) {
        var $trigger = $(".header-notification");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $(".show-notification").slideUp(300);
            $(".header-notification").removeClass('active');
        }
    });

    // card js end
    $.mCustomScrollbar.defaults.axis = "yx";
    $("#styleSelector .style-cont").slimScroll({
        setTop: "1px",
        height: "calc(100vh - 320px)",
    });
    $(".main-menu").mCustomScrollbar({
        setTop: "1px",
        setHeight: "calc(100% - 56px)",
    });
    /*chatbar js start*/
    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5,
        color: '#1b8bf9'
    });

    // search
    $("#search-friends").on("keyup", function () {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function () {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });

    //open friend chat
    $('.userlist-box').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    $('.back_friendlist').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.p-chat-user').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/

    $('[data-toggle="tooltip"]').tooltip();

    // wave effect js
    Waves.init();
    Waves.attach('.flat-buttons', ['waves-button']);
    Waves.attach('.float-buttons', ['waves-button', 'waves-float']);
    Waves.attach('.float-button-light', ['waves-button', 'waves-float', 'waves-light']);
    Waves.attach('.flat-buttons', ['waves-button', 'waves-float', 'waves-light', 'flat-buttons']);

    $('.form-control').on('blur', function () {
        if ($(this).val().length > 0) {
            $(this).addClass("fill");
        } else {
            $(this).removeClass("fill");
        }
    });
    $('.form-control').on('focus', function () {
        $(this).addClass("fill");
    });
});
$(document).ready(function () {
    $(".theme-loader").animate({
        opacity: "0"
    }, 1000);
    setTimeout(function () {
        $(".theme-loader").remove();
    }, 1000);

});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/** TinyMCE */
function TinyMCEInit(height = 300, fullpage = false, selector = '.tinymce') {
    /* TinyMCE */
    if ($("textarea" + selector).length <= 0) { return false; }
    tinymce.remove();
    tinymce.init({
        selector: selector,
        entity_encoding: (fullpage ? "''" : "'raw'"),
        forced_root_block: "",
        paste_auto_cleanup_on_paste: true,
        language: 'tr_TR', // select language
        language_url: 'https://cdn.jsdelivr.net/npm/tinymce-lang/langs/tr_TR.js',
        branding: false,
        image_advtab: true,
        plugins: (fullpage ? "fullpage " : "") + 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image responsivefilemanager media template link anchor codesample | ltr rtl',
        height: height,
        mobile: {
            theme: 'silver'
        },
        external_filemanager_path:base_url+"/filemanager/",
        filemanager_title:"Dosya YÃ¶neticisi" ,
        external_plugins: { "filemanager" : base_url+"/filemanager/plugin.min.js"},
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        // without images_upload_url set, Upload tab won't show up
        images_upload_url: base_url+'settings/uploadImage',
        convert_urls: false,
        // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', base_url+'settings/uploadImage');

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
    });
    /* TinyMCE */
}
/** TinyMCE */
function bs_input_file() {
    $(".input-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
