<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alunos = Aluno::orderByDesc('id')->get();
        return view('alunos.index', compact('alunos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas retorna a view do formulário
        return view('alunos.create');
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:alunos,email',
            'data_nascimento' => 'required|date',
        ]);

        Aluno::create([
        'nome' => $validated['nome'],
        'email' => $validated['email'],
        'data_nascimento' => $validated['data_nascimento'],
    ]);


        // Redireciona de volta para a lista com mensagem de sucesso
        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
        $aluno = alunos::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'done' => ['nullable'],
        ]);

        $aluno->update([
            'nome' => $validated['nome'],
            'done' => $request->has('done'),
        ]);

        return redirect()->route('tasks.index');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $aluno->delete();
        return redirect()->route('alunos.index');
        
    }
}
