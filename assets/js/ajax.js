class Ajax {

    constructor() {
        this.errorLog = null;
        this.error = false;
        this.result = null;
        this.headers = this.assign("headers");
    }

    setParams(params) {
        var str = '';
        for (var item in params) {
            str += '&' + item + '=' + params[item];
        }
        return str;
    }

    request(path, params, type, headers) {
        if (type === null) {
            type = 'POST';
        }

        var str = '';
        var request;

        for (var item in params) {
            str += '&' + item + '=' + params[item];
        }

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                request = { data: xhr.responseText, status: xhr.status };
            }
        };
        var headers = this.headers;
        if (type === 'GET') {
            xhr.open(type, path + '?' + str, false);

            Object.keys(headers).forEach(function (key) {
                xhr.setRequestHeader(key, headers[key]);
            });

            xhr.send();
        } else {
            xhr.open(type, path, false);
            Object.keys(headers).forEach(function (key) {
                xhr.setRequestHeader(key, headers[key]);
            });
            xhr.send(str);
        }

        if (xhr.status >= 500) {
            this.errorLog = "500 OK";
        }

        return request;
    }

    getResult() {
        return this.result;
    }

    getError() {
        return this.errorLog;
    }

    setHeader(key, value) {
        this.headers[key] = value;
    }

    /**
     * @param {String} url // url to request 
     * @param {object} data // data o     
     * @param {Object} params // method,type,then,catch,headers 
     * 
     */

    post(url, data, params) {

        var onRequest = {
            responseType: this.filtre("responseType", params)
        };

        // request options
        const options = {
            method: "POST",
            body: this.setParams(data),
            redirect: 'follow',
            mode: 'cors',
            headers: this.headers
        };

        return this.__send(url, options, onRequest.responseType);
    }

    /**
 * @param {String} url // url to request 
 * @param {object} data // data o     
 * @param {Object} params // method,type,then,catch,headers 
 * 
 */

    upload(url, data, params) {

        var onRequest = {
            responseType: this.filtre("responseType", params)
        };

        delete this.headers["Content-Type"];
        // request options
        const options = {
            method: "POST",
            body: data,
            redirect: 'follow',
            mode: 'cors',
            headers: this.headers
        };

        return this.__send(url, options, onRequest.responseType);
    }

    /**
     * @param {String} url // url to request   
     * @param {Object} params // method,type,then,catch,headers 
     * 
     */

    get(url, params) {

        var onRequest = {
            responseType: this.filtre("responseType", params)
        };
        // request options
        const options = {
            method: "GET",

            redirect: 'follow',
            mode: 'cors',
            headers: this.headers
        };

        return this.__send(url, options, onRequest.responseType);
    }

    __send(url, options, type) {
        this.headers = this.assign("headers");
        return fetch(url, options).then(response => response.text());
    }

    filtre(key, obj) {
        if (obj != null) {
            if (obj.hasOwnProperty(key)) {
                return obj[key];
            }
        }
        return this.assign(key);

    }

    assign(key) {
        switch (key) {
            case "method":
                return "POST";
            case "responseType":
                return "json";
            case "headers":
                return { "Content-Type": "application/x-www-form-urlencoded" };
            case "then":
                return function (response) {
                    console.log(response);
                };
            case "catch":
                return function (error) {
                    console.log(error);
                };
        }
    }

    convert(result, type) {
        console.log(result);
        switch (type) {
            case "json":
                if (/^[\],:{}\s]*$/.test(result.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                    return JSON.parse(result);
                }
                this.errorLog = "JSON ERROR";
                return null;
            case "xml":
                if (isXML(result)) {
                    return result;
                }
                this.errorLog = "XML ERROR";
                return null;
            default:
                return result;

        }
    }

    isXML(xmlStr) {
        var parseXml;

        if (typeof window.DOMParser != "undefined") {
            parseXml = function (xmlStr) {
                return (new window.DOMParser()).parseFromString(xmlStr, "text/xml");
            };
        } else if (typeof window.ActiveXObject != "undefined" && new window.ActiveXObject("Microsoft.XMLDOM")) {
            parseXml = function (xmlStr) {
                var xmlDoc = new window.ActiveXObject("Microsoft.XMLDOM");
                xmlDoc.async = "false";
                xmlDoc.loadXML(xmlStr);
                return xmlDoc;
            };
        } else {
            return false;
        }

        try {
            parseXml(xmlStr);
        } catch (e) {
            return false;
        }
        return true;
    }
}


var ajax = new Ajax();