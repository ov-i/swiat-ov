<?php

namespace App\Livewire\Admin\Posts\Comments;

use App\Livewire\Forms\PerPage;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Selectable;
use App\Livewire\Traits\Sortable;
use App\Repositories\Eloquent\Posts\CommentRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    use Searchable;

    use Selectable;

    use Sortable;

    private CommentRepository $commentRepository;

    #[Modelable]
    public PerPage $perPage;

    public function boot(
        CommentRepository $commentRepository,
    ): void {
        $this->authorize('viewAdmin', auth()->user())->asNotFound();

        $this->commentRepository = $commentRepository;
    }

    public function render(): View
    {
        $comments = $this->commentRepository->all();

        return view('livewire.admin.posts.comments.table', data: [
            'comments' => $comments,
        ]);
    }
}
