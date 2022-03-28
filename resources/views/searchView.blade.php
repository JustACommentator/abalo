<form method="GET" action="articles">
    <input type="text" name="search">
    <input type="submit">
</form>

<table>
    <tr>
        <th>Artikel</th>
        <th>Preis</th>
        <th>VerkäuferID</th>
        <th>Einstelldatum</th>
    </tr>

    @foreach($results as $result)

        <tr>
            <td>{{$result->ab_name}}</td>
            <td>{{$result->ab_price}}</td>
            <td>{{$result->ab_creator_id}}</td>
            <td>{{$result->ab_createdate}}</td>
        </tr>

    @endforeach
</table>
