<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
