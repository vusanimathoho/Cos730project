class Form {

    constructor(form) {
        this.id = form;
    }

    onSuccess() {
        console.log("Successful");
    }

    searchNode(node, tags) {
        for (var i in tags) {
            if (node.localName == tags[i]) {
                return true;
            }
        }

        return false;
    }

    evaluate(nodes, tags, arr) {
        var len = nodes.childElementCount;
        if (this.searchNode(nodes, tags)) {
            arr[nodes.name] = nodes.value;
        } else if (len > -1) {

            for (var x = 0; x < nodes.childNodes.length; x++) {

                this.evaluate(nodes.childNodes.item(x), tags, arr);
            }
        }
    }

    check(nodes, tags, arr) {
            var len = nodes.childElementCount;
            if (this.searchNode(nodes, tags)) {
                nodes.style = "box-shadow:1px 1px 10px green;";;
            } else if (len > -1) {

                for (var x = 0; x < nodes.childNodes.length; x++) {

                    this.evaluate(nodes.childNodes.item(x), tags, arr);
                }
            }
        }
        /**
         * evaluate the form get all data  in input and textarea
         * @param {String} id form_id
         * @returns {Object} form input fields and textarea data.
         * 
         */
    validate(id) {
            var form = document.getElementById(id);
            var nodes = form.childNodes;
            var arr = {};
            for (var x in nodes) {
                this.check(nodes.item(x), ["input", "textarea", "select"], arr);
            }

            return arr;
        }
        /**
         * evaluate the form get all data  in input and textarea
         * @param {String} id form_id
         * @returns {Object} form input fields and textarea data.
         * 
         */
    formData(id) {
        var form = document.getElementById(id);
        var nodes = form.childNodes;
        var arr = {};
        for (var x in nodes) {
            this.evaluate(nodes.item(x), ["input", "textarea", "select"], arr);
        }

        return arr;
    }

    errorDisplay(errors) {

        var mess = document.getElementsByClassName('error-message');
        if (mess) {
            while (mess[0]) {
                mess[0].parentNode.removeChild(mess[0]);
            }
        }

        if (errors != null) {
            var x = 0;
            for (var i in errors) {
                x++;
                var err = document.getElementById('err');
                var ele = document.getElementById(i);
                var para = document.createElement("p");
                document.getElementsByName(i)[0].style = "box-shadow:1px 1px 10px red;";
                para.className = 'error-message';

                para.innerHTML = errors[i];
                para.style = "color : red; font-weight: bold;";
                ele.appendChild(para);
                err.className = 'error-message';
                err.style = "color : red; font-weight: bold;";
                err.innerHTML = x + ' invaild info please correct';

            }
        } else {

        }
    }
}

var form = new Form();