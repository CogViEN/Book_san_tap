function notifySuccess(message = '') {
    $.toast({
        heading: "Success",
        text: message,
        showHideTransition: "slide",
        position: "top-right",
        icon: "success",
    });
}

function notifyError(message = '') {
    $.toast({
        heading: "Error",
        text: message,
        showHideTransition: "slide",
        position: "top-right",
        icon: "error",
    });
}