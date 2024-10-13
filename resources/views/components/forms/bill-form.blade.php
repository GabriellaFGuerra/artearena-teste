<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    {{ $slot }}
</form>
