<a href="{{ route("users.edit", $user) }}" class="mr-2">
    <i class="fas fa-pencil-alt text-success"></i>
</a>

<a href="javascript:void(0)" data-url="{{ route("users.destroy", $user) }}" class="delete">
    <i class="fas fa-trash text-danger"></i>
</a>