function LoginModel() {

    this.callApi = function(login, userModel, postCallback) {
        console.log("In Api");
        var data = JSON.stringify(userModel);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', login, true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.send(data);

        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr);
                console.log(xhr.getAllResponseHeaders());
                var response = JSON.parse(xhr.responseText);
                console.log(response);
                postCallback(response);
            }
        }
    }
    this.onSuccess = function(input, ouput) {
        return {
            input: input,
            ouput: ouput,
        };
    }
    this.onFailure = function(input, ouput) {
        return {
            input: input,
            ouput: ouput,
            errorMsg: ouput.data
        };
    }
}