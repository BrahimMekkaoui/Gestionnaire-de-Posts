@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tous les posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Créer un nouveau post</a>
    </div>

    @if($posts->count() > 0)
        <div class="list-group">
            @foreach($posts as $post)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ $post->title }}</h5>
                            <p class="mb-1 text-muted">{{ Str::limit($post->content, 100) }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">Afficher</a>
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
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Aucun post trouvé. Créez votre premier post !</div>
    @endif
@endsection
