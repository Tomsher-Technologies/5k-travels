<form action="{!! $url !!}" {!! $attributes !!}>
    @csrf
    <button type="submit" data-class="{!! $basename !!}__link" class=" w-100 btn btn_theme">
        <span class="{!! $basename !!}__label">{{ $label }}</span>
    </button>
</form>
