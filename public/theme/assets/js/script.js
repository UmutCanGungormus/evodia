$(document).ready(function () {
    $(document).on("click", ".deleteToFavourite", function () {
        let url = $(this).data("url");
        let id = $(this).data("id");
        let current = $(this);
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {"id": id}
        }).done(function (response) {
            if (response.status) {
                console.log(current.next().find(".addToFavourite"))
                current.parent().next().find(".addToFavourite").removeClass("d-none");
                current.addClass("d-none")
                iziToast.success({
                    message: response.msg,
                    title: response.title,
                    position: "topCenter",
                    displayMode: "once"
                })
            } else {
                iziToast.error({
                    message: response.msg,
                    title: response.title,
                    position: "topCenter",
                    displayMode: "once"
                })
            }
        })
    })
    $(document).on("click", ".addToFavourite", function () {
        let url = $(this).data("url");
        let id = $(this).data("id");
        let current = $(this);
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {"id": id}
        }).done(function (response) {
            if (response.status) {
                current.parent().prev().find(".deleteToFavourite").removeClass("d-none");
                current.addClass("d-none")
                iziToast.success({
                    message: response.msg,
                    title: response.title,
                    position: "topCenter",
                    displayMode: "once"
                })
            } else {
                console.log(current.prev());
                iziToast.error({
                    message: response.msg,
                    title: response.title,
                    position: "topCenter",
                    displayMode: "once"
                })
            }
        })
    })
})
function isEmpty(obj) {
    if (typeof obj == "number") return false;
    else if (typeof obj == "string") return obj.length == 0;
    else if (Array.isArray(obj)) return obj.length == 0;
    else if (typeof obj == "object")
        return obj == null || Object.keys(obj).length == 0;
    else if (typeof obj == "boolean") return false;
    else return !obj;
}

function createModal( modalClass = null, modalTitle = null, modalSubTitle = null, width = 600, bodyOverflow = true, padding = "20px", radius = 0, headerColor = "#e20e17", onOpening = function () {}, onOpened = function () {}, onClosing = function () {}, onClosed = function () {}, afterRender = function () {}, onFullScreen = function () {}, onResize = function () {}, fullscreen = true, openFullscreen = false, closeOnEscape = true, closeButton = true, overlayClose = false, autoOpen = 0, zindex = 999 ) {
    if ( modalClass !== "" || modalClass !== null ) {
        $( modalClass ).iziModal( {
            title: modalTitle,
            subtitle: modalSubTitle,
            headerColor: headerColor,
            width: width,
            zindex: zindex,
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
        } );
        return true;
    }
}
function destroyModal(modalClass=null){
    $(modalClass).iziModal('destroy');
}
function openModal( modalClass = null, event = function () {} ) {
    $( modalClass ).iziModal( 'open', event );
}

function closeModal( modalClass = null, event = function () {} ) {
    $( modalClass ).iziModal( 'close', event );
}
