@foreach($datas as $data)
<tr class="post-item">
    <td class="align-middle">
        <img style="height: 90px;" class="profile-user-img img-responsive img-bordered" src="{{ getImage($data->photo) }}">
    </td>
    <td class="align-middle">{{ $data->name }}</td>
    <td class="align-middle">{{ $data->type->label() }}</td>
    <td class="align-middle">{{ $data->created_at->format('d/m/Y') }}</td>
    <td class="align-middle">{{ $data->status->label() }}</td>
    <td class="align-middle">
        <a href="{{ route('post.edit', $data->id) }}" class="btn btn-sm btn-product">
            <i class="fa-regular fa-pen-to-square"></i>
        </a>
        <a href="#" class="btn btn-sm btn-product btn-delete" data-id="{{ $data->id }}">
            <i class="fa-regular fa-trash-can"></i>
        </a>
        <form id="delete-form-{{ $data->id }}" action="{{ route('post.destroy', $data->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </td>
</tr>
@endforeach