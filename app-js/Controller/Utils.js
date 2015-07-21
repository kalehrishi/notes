Notes.utils = {
    post: function (url, request, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest(), data = JSON.stringify(request);
        
        xhr.open("POST", url, isAsync);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
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