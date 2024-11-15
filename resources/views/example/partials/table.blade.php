@foreach($examples as $example)
<tr>
    <td>{{ $example->id }}</td>
    <td>{{ $example->name }}</td>
    <td>{{ $example->description }}</td>
    <td>{{ $example->price }}</td>
    <td>
        <!-- Your action buttons -->
        <button class="btn btn-sm btn-primary editExampleBtn" data-id="{{ $example->id }}">Edit</button>
        <button class="btn btn-sm btn-danger deleteExampleBtn" data-id="{{ $example->id }}">Delete</button>
    </td>
</tr>
@endforeach