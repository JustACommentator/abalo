<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Artikelsuche</title>
    <link rel="stylesheet" href="./assets/css/shoppingCart.css">
</head>
<body>

<script>



    "use strict";


    class Item {
        _name = "";
        _price = 0;
        _id = 0;

        constructor(id, name, price) {
            this._name = name;
            this._price = price;
            this._id = id
        }

        get name() {
            return this._name;
        }

        get price() {
            return this._price;
        }

        get id() {
            return this._id;
        }
    }

    class ShoppingCart {
        _content = [];

        addItem(item) {
            if (this._content.indexOf(item.name) == -1) {
                this._content.push(item.name);
                let tr = document.createElement("tr");
                tr.setAttribute('id', item.id)
                let tdID = document.createElement("td");
                let tdName = document.createElement("td");
                let tdPrice = document.createElement("td");
                let tdDelete = document.createElement("td");
                tr.append(tdID, tdName, tdPrice, tdDelete);
                tdID.innerText = item.id
                tdName.innerText = item.name;
                tdPrice.innerText = item.price;
                tdDelete.innerHTML = "&#10134;"
                tdDelete.addEventListener("click", function () {

                    event.target.parentNode.remove();
                    shoppingCart._content.splice(shoppingCart._content.indexOf(this.parentElement.children[0].innerHTML),1);
                    let id = this.parentElement.id
                    deleteFromShoppingCart(id)
                })
                document.getElementById("shoppingTable").append(tr);
            }
        }

        getTotal() {
            let sum = 0;
            this._content.forEach(item => sum += item.price);
        }
    }

    let shoppingCart = new ShoppingCart();

    function addItemToShoppingCart(id, name, price) {
        shoppingCart.addItem(new Item(id, name, price))
    }


    let shoppingCartID = null;

    // M3 Aufgabe 10

    function addItem(id) {
        let xhr = new XMLHttpRequest()

        let url = '/api/shoppingcart'

        xhr.open("POST", url, true)
        xhr.setRequestHeader("X-CSRF-TOKEN", document.getElementById("csrf-token").getAttribute('content'));
        xhr.setRequestHeader('Content-Type', 'application/json')


        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    let response = JSON.parse(xhr.responseText)
                    if(response && Object.keys(response).length > 0){
                        addItemToShoppingCart(response['id'], response['name'], response['price'])

                        if(shoppingCartID == null){
                            shoppingCartID = response['shoppingCart']
                        }
                    }

                } else {
                    console.error(xhr.statusText);
                }
            }
        };

        xhr.onerror = function () {
            console.error(xhr.statusText)
        };

        xhr.send(JSON.stringify({
            'id' : id
        }))
    }

    function deleteFromShoppingCart(id){

        let xhr = new XMLHttpRequest()

        let url = '/api/shoppingcart/' + shoppingCartID + '/articles/' + id

        xhr.open("DELETE", url, true)
        xhr.setRequestHeader("X-CSRF-TOKEN", document.getElementById("csrf-token").getAttribute('content'));
        xhr.setRequestHeader('Content-Type', 'application/json')


        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
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

    function search() {
        let value = document.getElementById('search').value

        let xhr = new XMLHttpRequest()

        const params = new URLSearchParams({
            'search' : value
        });

        let url = '/api/articles?' + params.toString();


        xhr.open("GET", url)
        xhr.setRequestHeader("X-CSRF-TOKEN", document.getElementById("csrf-token").getAttribute('content'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
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


<div id="shoppingCart">
    <table id="shoppingTable">
        <tr id="headRow">
            <td>Name</td>
            <td>Preis[€]</td>
            <td>Entfernen</td>
        </tr>
    </table>
</div>



<input type="text" id="search" name="search" @if($search != null) value="{{$search}}" @else placeholder="Suchbegriff" @endif>
<input type="submit" onclick="search()">

<input type="hidden" id="csrf-token" content="{{ csrf_token() }}">
<table>
    <tr>
        <th>Bild</th>
        <th>Artikel</th>
        <th>Preis</th>
        <th>VerkäuferID</th>
        <th>Einstelldatum</th>
    </tr>

    @foreach($results as $result)
                <tr id="{{$result->id}}">
                    <td>
                        @if(file_exists("assets/img/$result->id.jpg"))
                            <img src="assets/img/{{$result->id}}.jpg" alt="alt">
                        @elseif(file_exists("assets/img/$result->id.png"))
                            <img src="assets/img/{{$result->id}}.png" alt="alt">
                        @endif
                    </td>
                    <td>{{$result->ab_name}}</td>
                    <td>{{$result->ab_price}}</td>
                    <td>{{$result->ab_creator_id}}</td>
                    <td>{{$result->ab_createdate}}</td>
                    <td onclick="addItem({{$result->id}})">&#10133;</td>
                </tr>

    @endforeach
</table>
</body>
</html>
