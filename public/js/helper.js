function notifySuccess(message = "") {
    $.toast({
        heading: "Success",
        text: message,
        showHideTransition: "slide",
        position: "top-right",
        icon: "success",
    });
}

function notifyError(message = "") {
    $.toast({
        heading: "Error",
        text: message,
        showHideTransition: "slide",
        position: "top-right",
        icon: "error",
    });
}

function checkTimeSlotValid(string) {
    if (string.length !== 11) return "wrong format string timeslot";
    if (string[2] != ":" || string[8] != ":" || string[5] != "-") {
        return "wrong format string timeslot";
    }
    if(string[0] != "0" && string[0] != "1" && string[0] != "2"){
        return 'Invalid string timeslot';
    }
    if (string[0] == "0") {
        if (
            string[1] != "1" &&
            string[1] != "2" &&
            string[1] != "3" &&
            string[1] != "4" &&
            string[1] != "5" &&
            string[1] != "6" &&
            string[1] != "7" &&
            string[1] != "8" &&
            string[1] != "9"
        )
        return 'Invalid string timeslot';
    }
    else if(string[0] == "1"){
        if (
            string[1] != "0" &&
            string[1] != "1" &&
            string[1] != "2" &&
            string[1] != "3" &&
            string[1] != "4" &&
            string[1] != "5" &&
            string[1] != "6" &&
            string[1] != "7" &&
            string[1] != "8" &&
            string[1] != "9"
        )
        return "Invalid string timeslot";
    }
    else if(string[0] == "2"){
        if (
            string[1] != "0" &&
            string[1] != "1" &&
            string[1] != "2" &&
            string[1] != "3" &&
            string[1] != "4" 
        )
        return "Invalid string timeslot";
    }

    if (string[6] == "0") {
        if (
            string[7] != "1" &&
            string[7] != "2" &&
            string[7] != "3" &&
            string[7] != "4" &&
            string[7] != "5" &&
            string[7] != "6" &&
            string[7] != "7" &&
            string[7] != "8" &&
            string[7] != "9"
        )
        return 'Invalid string timeslot';
    }
    else if(string[6] == "1"){
        if (
            string[7] != "0" &&
            string[7] != "1" &&
            string[7] != "2" &&
            string[7] != "3" &&
            string[7] != "4" &&
            string[7] != "5" &&
            string[7] != "6" &&
            string[7] != "7" &&
            string[7] != "8" &&
            string[7] != "9"
        )
        return "Invalid string timeslot";
    }
    else if(string[6] == "2"){
        if (
            string[7] != "0" &&
            string[7] != "1" &&
            string[7] != "2" &&
            string[7] != "3" &&
            string[7] != "4" 
        )
        return "Invalid string timeslot";
    }
    return "true";
}

function checkCostValid(cost){
   return cost > 0;
}