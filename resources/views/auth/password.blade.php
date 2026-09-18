<x-layouts.base title="Recuperar acesso">
<div class="container py-5" style="max-width:520px"><div class="card p-4 shadow-sm"><h1 class="h4">{{ $reset ? 'Definir senha' : 'Recuperar acesso' }}</h1>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route($reset?'password.update':'password.email') }}">@csrf
@if($reset)<input type="hidden" name="token" value="{{ $token }}">@endif
<label class="form-label" for="email">E-mail</label><input id="email" class="form-control mb-3" type="email" name="email" value="{{ old('email',$email??'') }}" required>
@if($reset)<label class="form-label" for="password">Nova senha (12 caracteres, letras e números)</label><input id="password" class="form-control mb-3" type="password" name="password" minlength="12" autocomplete="new-password" required><label class="form-label" for="confirmation">Confirmar senha</label><input id="confirmation" class="form-control mb-3" type="password" name="password_confirmation" autocomplete="new-password" required>@endif
<button class="btn btn-primary w-100">{{ $reset?'Salvar senha':'Enviar instruções' }}</button></form><a class="mt-3" href="{{ route('login') }}">Voltar ao login</a></div></div>
</x-layouts.base>