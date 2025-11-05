<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}" required>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Senha" required>
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required>
    <button type="submit">Registrar</button>
</form>
