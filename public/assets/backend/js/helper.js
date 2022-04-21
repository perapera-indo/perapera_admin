"use strict";

var AjaxHandler = (function($) {
    var handler = {};

    handler.post = function(url, data, success, error) {
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(result) {
                success(result);
            },
            error: function(ex) {
                error(ex);
            }
        });
    }

    handler.get = function(url, data, success, error) {
        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: function(result) {
                success(result);
            },
            error: function(ex) {
                error(ex);
            }
        });
    }

    return handler;

}(jQuery));
