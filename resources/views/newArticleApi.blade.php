
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<script type="text/javascript">
    "use strict";

    function  submitForm(){
        let price = document.getElementById('preis').value;
        let name = document.getElementById('name').value;
        let beschreibung = document.getElementById('beschreibung').value;

        if(name !== null && parseInt(price) > 0){
            event.preventDefault();
            sendData(name, price, beschreibung)
        }
        else{
        }
    }

    function sendData(name, preis, beschreibung){
        let xhr = new XMLHttpRequest()

        const params = new URLSearchParams({
            'name': name,
            'preis': preis,
            'beschreibung': beschreibung
        });

        let url = '/api/articles?' + params.toString();


        xhr.open("POST", url)
        xhr.setRequestHeader("X-CSRF-TOKEN", document.getElementById("csrf-token").getAttribute('content'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    let responseLabel = JSON.parse(xhr.responseText)
                    let label = document.getElementById("id")
                    label.innerHTML = 'Created id is: '  + responseLabel['id']
                } else {
                    console.error(xhr.statusText);
                }
            }
        };

        xhr.onerror = function () {
            console.error(xhr.statusText)
        };

        xhr.send()

    }
</script>
    <input type="hidden" id="csrf-token" content="{{ csrf_token() }}">
    <div>
        <label for="name"> Name <br>
            <input name="name" id="name">
        </label>
    </div>
    <div>
        <label for="preis"> Preis <br>
            <input name="preis" id="preis">
        </label>
    </div>
    <div>
        <label for="beschreibung"> Beschreibung <br>
            <input name="beschreibung" id="beschreibung">
        </label>
    </div>
    <button id="submit" onclick="submitForm()">Speichern</button>

    <div>
        <label id="id"></label>
    </div>
</body>
</html>
