<h1>Bem-vindo, {{ auth()->user()->name }}</h1>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Sair</button>
</form>
