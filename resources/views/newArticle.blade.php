<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<script type="text/javascript">
    "use strict";
    const labels = ['Name', 'Preis', 'Beschreibung']
    let form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "/newArticle");
    form.id = 'form';

    let csrftoken = '{{ csrf_token() }}'
    let csrf = document.createElement('input');
    csrf.setAttribute("type", "hidden");
    csrf.setAttribute("name", "_token");
    csrf.setAttribute("value", csrftoken);
    form.append(csrf);

    let br = document.createElement("br");
    labels.forEach((label) => {
        let labelElement = document.createElement('label');
        labelElement.innerHTML = label;

        let inputElement = null;

        if(label === 'Name' || label === 'Preis'){
            inputElement = document.createElement('input');
            inputElement.setAttribute("type", 'text');
        } else {
            inputElement = document.createElement('textarea');
        }
        inputElement.setAttribute("name",label.toLowerCase());
        inputElement.setAttribute("id",label.toLowerCase());
        form.append(labelElement);
        form.append(br.cloneNode());
        form.append(inputElement);
        form.append(br.cloneNode());
    });

    let submitElement = document.createElement("button");
    submitElement.innerHTML = 'Speichern';
    submitElement.addEventListener('click', submitForm);


    document.body.appendChild(form);
    document.body.appendChild(submitElement);

    function  submitForm(){
        let price = document.getElementById('preis').value;
        let name = document.getElementById('name');
        let form = document.getElementById('form');

        console.log(price);
        if(name !== null && parseInt(price) > 0){
            form.submit();
            console.log('submitted');
        }
        else{
            console.log('else block');
        }
    }
</script>
@if($error)
    <script>alert(JSON.parse({{$error}}))</script>
    @endif
</body>
</html>
