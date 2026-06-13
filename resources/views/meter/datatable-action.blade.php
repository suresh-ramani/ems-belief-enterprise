<a href="{{ route("meters.edit", $meter) }}" class="mr-2">
    <i class="fas fa-pencil-alt text-success"></i>
</a>

<a href="javascript:void(0)" data-url="{{ route("meters.destroy", $meter) }}" class="delete">
    <i class="fas fa-trash text-danger"></i>
</a>