$(document).ready(function () {
    $("#clickme").click(function () {
    /* This example is for the .getJSON method...but if JSON cannot find the file, or some other error occurs in data transfer, there is no functionality...
        $.getJSON("data19.json", function (data) {  //Normally the getJSON function will go grab data dynamically from a database...once received it will pass it into the function (second) argument
            var items = [];
            $.each(data, function (key, val) {
                items.push("<li id=\"" + key + "\">" + val + "</li>");
            });
            $("<ul/>", {  // you can also pass a new HTML tag into the jQuery function
                "class": "interest-list",
                html: items.join("")  // the .join method will concatenate each of the items in the array together into a single string; if we wanted separators, we would pass that into the method as an argument.
            }).appendTo("body");  // we are taking the newly made html object and appending it to the existing body element.
        }); // end JSON call
    }); // end the click event handler     */

    // The .ajax method call takes an object literal that processes the data transfer, and can have different functions
    //   defined for success and failure (by error code)
        $.ajax({
            url: "data19.json",
            dataType: "json",
            success: function (data) {
                var items = [];
                $.each(data, function (key, val) {
                    items.push("<li id=\"" + key + "\">" + val + "</li>");
                });
                $("<ul/>", {  // you can also pass a new HTML tag into the jQuery function
                    "class": "interest-list",
                    html: items.join("")  // the .join method will concatenate each of the items in the array together into a single string; if we wanted separators, we would pass that into the method as an argument.
                }).appendTo("body");  // we are taking the newly made html object and appending it to the existing body element.
            },
            statusCode: {
                404: function () {
                    alert("There was a problem with the server.  Try again soon!");
                }
            }
        }); // end .ajax method.
    });  //end the click event handler
});  //end the .ready function