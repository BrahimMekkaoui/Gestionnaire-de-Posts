@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">{{ $post->title }}</h2>
            <div>
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $post->content }}</p>
            <div class="text-muted small mt-4">
                Créé : {{ $post->created_at->format('d/m/Y H:i') }} | 
                Dernière mise à jour : {{ $post->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                &larr; Retour à tous les posts
            </a>
        </div>
    </div>
@endsection
