<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD de Tarefas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { max-width: 700px; margin: 0 auto; }
        input[type="text"] { width: 100%; padding: 10px; }
        button { padding: 8px 12px; cursor: pointer; }
        .row { display: flex; gap: 10px; align-items: center; }
        .task { padding: 12px; border: 1px solid #ddd; margin-top: 10px; border-radius: 8px; }
        .task form { margin: 0; }
        .muted { color: #666; font-size: 12px; }
    </style>
</head>
<body>
<div class="box">
    <h2>✅ CRUD de Tarefas (tudo na mesma tela)</h2>

    {{-- Erros --}}
    @if ($errors->any())
        <div style="background:#ffe5e5;padding:12px;border-radius:8px;">
            <b>Ops:</b>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form criar --}}
    <form action="{{ route('tasks.store') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <div class="row">
            <div style="flex:1;">
                <input type="text" name="title" placeholder="Digite uma tarefa..." value="{{ old('title') }}">
            </div>
            <button type="submit">Adicionar</button>
        </div>
    </form>

    <hr style="margin: 20px 0;">

    {{-- Listagem + Editar + Deletar na mesma tela --}}
    @forelse($tasks as $task)
        <div class="task">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <input type="checkbox" name="done" {{ $task->done ? 'checked' : '' }}>
                    <div style="flex:1;">
                        <input type="text" name="title" value="{{ $task->title }}">
                        <div class="muted">#{{ $task->id }} • {{ $task->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <button type="submit">Salvar</button>
                </div>
            </form>

            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="margin-top:10px;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Excluir essa tarefa?')">Excluir</button>
            </form>
        </div>
    @empty
        <p>Nenhuma tarefa cadastrada ainda.</p>
    @endforelse
</div>
</body>
</html>