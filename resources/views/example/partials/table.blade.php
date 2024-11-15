@foreach ($examples as $example)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $example->name }}</td>
    <td>{{ $example->description }}</td>
    <td>
        <button class="btn btn-sm btn-info editExampleBtn" data-id="{{ $example->id }}">Edit</button>
        <button class="btn btn-sm btn-danger deleteExampleBtn" data-id="{{ $example->id }}">Delete</button>
    </td>
</tr>
@endforeach