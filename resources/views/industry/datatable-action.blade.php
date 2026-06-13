<a href="{{ route("industries.edit", $industry) }}" class="mr-2">
    <i class="fas fa-pencil-alt text-success"></i>
</a>

<a href="javascript:void(0)" data-url="{{ route("industries.destroy", $industry) }}" class="delete">
    <i class="fas fa-trash text-danger"></i>
</a>