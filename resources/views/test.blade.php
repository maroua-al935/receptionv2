<html>
<head>
@livewireStyles
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<form action="{{ route('p_test') }}" method="post">
@csrf
<input name="email" type="text">
<input name="pass" type="password">
<button type="button" name="send"  wire:click.prevent="$emit('listen')">send</button>
</form>
<livewire:test />
@livewireScripts
</body>
</html>
