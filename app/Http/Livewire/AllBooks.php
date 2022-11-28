<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AllBooks extends Component
{
    public $title, $isbn, $publisher, $published_at, $cover_image, $genre, $authors, $revision_number, $cid;

    public $update = false;
    public $delete = null;

    public $search = '';

    use WithPagination;
    use WithFileUploads;
    protected $listeners = [
        'deleteConfirm' => 'delete',
    ];

    // refreshinputs after saved
    function refreshInputs()
    {
        $this->title = '';
        $this->published_at = '';
        $this->publisher = '';
        $this->authors = '';
        $this->cover_image = '';
        $this->revision_number = '';
        $this->genre = '';
        $this->isbn = '';
        $this->update = false;
    }

    function add()
    {
        $this->update = false;
    }
    protected $messages = [
        'cover_image.image' => 'Image must be png, jpg, jpeg format',
        'cover_image.max' => 'Image must be less than 500kb',
        'cover_image.required' => 'Image must not be empty',
        'published_at.required' => 'Published Date must not be empy',
        'published_at.date' => 'Date must be in the past or today'
    ];

    public function save()
    {
        $data = $this->validate(
            [
                'title' => 'required|unique:books,title',
                'cover_image' => 'nullable|image|max:512',
                'authors' => 'required',
                'revision_number' => 'required|numeric',
                'publisher' => 'required',
                'published_at' => 'required|date|before_or_equal:today',
                'isbn' => 'required',
                'genre' => 'required',
            ]
        );
        // imageurl
        if ($this->cover_image) {
            $url = $this->cover_image->store('book', 'public');
        }

        $saved = Book::create(array_merge($data, ['cover_image' => $url]));


        if ($saved) {
            $this->refreshInputs();
            $this->dispatchBrowserEvent('closeModal');
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => strtoupper($this->title) . ' added to library',
                'title' => 'Book Added',
                'timer' => 3000,
            ]);
        }
        $this->refreshInputs();
    }

    public function confirmDelete(Book $book)
    {

        // $book = Book::findOrFail($id);

        $this->delete = $book->id;

        $this->dispatchBrowserEvent('swal:confirm');
    }
    public function edit(Book $book)
    {

        // $book = Book::findOrFail($id);

        $this->cid = $book->id;
        $this->title = $book->title;
        $this->isbn = $book->isbn;
        $this->publisher = $book->publisher;
        $this->published_at = $book->published_at;
        $this->genre = $book->genre;
        $this->authors = $book->authors;
        $this->revision_number = $book->revision_number;
        $this->update = true;
        $this->dispatchBrowserEvent('showModal');
    }

    function update()
    {

        $book = Book::find($this->cid);
        $data = $this->validate(
            [
                'title' => 'required|unique:books,title,' . $this->cid,
                'cover_image' => 'nullable|image|max:512',
                'authors' => 'required',
                'revision_number' => 'required|numeric',
                'publisher' => 'required',
                'published_at' => 'required|date|before_or_equal:today',
                'isbn' => 'required',
                'genre' => 'required',
            ]
        );
        // imageurl
        if ($this->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
            $url = $this->cover_image->store('book', 'public');
        }

        $saved = $book->update(array_merge($data, ['cover_image' => $url ?? $book->cover_image]));


        if ($saved) {
            $this->refreshInputs();
            $this->dispatchBrowserEvent('closeModal');
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => strtoupper($this->title) . ' added to library',
                'title' => 'Book Added',
                'timer' => 3000,
            ]);
        }
        $this->refreshInputs();
        return redirect()->back();
    }

    public function delete()
    {

        $book = Book::findOrFail($this->delete);


        // if the book has a cover image delete the image along with data
        if ($book->cover_image || Storage::exists($book->cover)) {
            Storage::disk('public')->delete($book->cover_image);
        }


        $true = $book->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => $book->title . ' has deleted Successfully from library',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->update = false;
        $this->refreshInputs();
        return redirect()->back();
    }

    public function render()
    {
        $term = '%' . $this->search . '%';
        $books = Book::where('authors', 'LIKE', $term)->orWhere('title', 'LIKE', $term)->orWhere('isbn', 'LIKE', $term)->orWhere('published_at', 'LIKE', $term)->paginate(5);
        return view('livewire.all-books', compact(['books']));
    }
}