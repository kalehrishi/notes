Notes.utils = {
    post: function (url, request, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest(), data = JSON.stringify(request);
        console.log(data);
        xhr.open("POST", url, isAsync);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);

        this.onreadystatechange(xhr, onSuccess, onFailure);
    },

    get: function (url, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest();
        
        xhr.open("GET", url, isAsync);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send();

        this.onreadystatechange(xhr, onSuccess, onFailure);
    },

    delete: function (url, isAsync, onSuccess, onFailure) {
        console.log("In Delete XHR");
        var xhr = new XMLHttpRequest();
        
        xhr.open("DELETE", url, isAsync);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send();

        this.onreadystatechange(xhr, onSuccess, onFailure);
        
    },

    onreadystatechange: function (xhr,onSuccess, onFailure) {
        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("XHR====",xhr);
                var response = JSON.parse(xhr.responseText);
                console.log("OnXhr Success Response: ", response);
                if (response.status === 0) {
                    onFailure(response);
                } else {
                    onSuccess(response);
                }
            }
        };
    }
};