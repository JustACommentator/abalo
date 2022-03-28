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

        <tr>
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
        </tr>

    @endforeach
</table>
