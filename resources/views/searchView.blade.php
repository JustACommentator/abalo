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

        constructor(name, price) {
            this._name = name;
            this._price = price;
        }

        get name() {
            return this._name;
        }

        get price() {
            return this._price;
        }
    }

    class ShoppingCart {
        _content = [];

        addItem(item) {
            if (this._content.indexOf(item.name) == -1) {
                this._content.push(item.name);
                let tr = document.createElement("tr");
                let tdName = document.createElement("td");
                let tdPrice = document.createElement("td");
                let tdDelete = document.createElement("td");
                tr.append(tdName, tdPrice, tdDelete);
                tdName.innerText = item.name;
                tdPrice.innerText = item.price;
                tdDelete.innerHTML = "&#10134;"
                tdDelete.addEventListener("click", function () {
                    //TODO: Delete item from this._content
                    event.target.parentNode.remove();
                    shoppingCart._content.splice(shoppingCart._content.indexOf(this.parentElement.children[0].innerHTML),1);
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

    function addItem(element) {
        shoppingCart.addItem(new Item(
            element.parentNode.children[1].innerHTML,
            element.parentNode.children[2].innerHTML));
    }

    function example() {
        console.log("Test");
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


<form method="GET" action="/articles">
    <input type="text" name="search" @if($search != null) value="{{$search}}" @else placeholder="Suchbegriff" @endif>
    <input type="submit">
</form>

<table>
    <tr>
        <th>Bild</th>
        <th>Artikel</th>
        <th>Preis</th>
        <th>VerkäuferID</th>
        <th>Einstelldatum</th>
    </tr>

    @foreach($results as $result)

        <tr id="{{$result->article_name}}">
            <td>

                @if(file_exists("assets/img/$result->id.jpg"))
                    <img src="assets/img/{{$result->id}}.jpg" alt="alt">
                @elseif(file_exists("assets/img/$result->id.png"))
                    <img src="assets/img/{{$result->id}}.png" alt="alt">
                @endif
            </td>
            <td>{{$result->article_name}}</td>
            <td>{{$result->article_price}}</td>
            <td>{{$result->seller}}</td>
            <td>{{$result->ab_createdate}}</td>
            <td onclick="addItem(this)">&#10133;</td>
        </tr>

    @endforeach
</table>
</body>
</html>
