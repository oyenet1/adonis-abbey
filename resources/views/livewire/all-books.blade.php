<div class="w-full rounded-xl bg-white p-8">
	<div class="flex items-center justify-between">
		<div class="flex items-center space-x-4">
			<h2 class="my-6 text-2xl font-semibold uppercase text-gray-700 dark:text-gray-200">Books</h2>
			<button data-toggle="modal" data-target="#form" wire:click="add()"
				class="rounded bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-500 focus:outline-none">Add Book</button>
		</div>
		<form action="">
			<input type="search" wire:model='search'
				class="rounded-md border-2 border-green-600 p-2 text-sm placeholder-gray-400" placeholder="search book">
		</form>
	</div>
	<!-- The Modal -->
	<div class="modal fade" id="form" wire:ignore.self>
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-lg font-medium">
						@if ($update)
							Edit Book details
						@else
							Add new Book
						@endif
					</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form wire:submit.prevent=@if ($update) 'update' @else 'save' @endif
						class="w-ful row h-96 overflow-y-auto px-3" enctype="multipart/form-data">
						<div class="grid grid-cols-2 gap-4">
							<div class="w-full">
								<label for="title" class="mb-1 text-sm font-normal text-gray-600">Title</label>
								<input type="text" wire:model.defer="title"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('title')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal text-gray-600">Authors</label>
								<input type="text" wire:model.defer="authors"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('authors')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal text-gray-600">Cover Image</label>
								<input type="file" wire:model.defer="cover_image"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('cover_image')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal text-gray-600">ISBN</label>
								<input type="text" wire:model.defer="isbn"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('isbn')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal capitalize text-gray-600">revision number</label>
								<input type="text" wire:model.defer="revision_number"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('revision_number')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal capitalize text-gray-600">publishers</label>
								<input type="text" wire:model.defer="publisher"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('publisher')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="w-full">
								<label for="authors" class="mb-1 text-sm font-normal capitalize text-gray-600">Publishes date</label>
								<input type="date" wire:model.defer="published_at"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('published_at')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
							<div class="mb-3 w-full">
								<label for="authors" class="mb-1 text-sm font-normal capitalize text-gray-600">genre</label>
								<input type="text" wire:model.defer="genre"
									class="focus-within: w-full rounded border-2 p-2 font-medium placeholder-gray-400 focus:border-green-600 focus:outline-none">
								@error('genre')
									<span class="text-xs font-normal text-red-600">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="my-auto flex justify-end text-right lg:col-span-2">
							@if ($update)
								<button type="submit"
									class="rounded border-2 border-green-500 bg-green-600 py-2 px-3 text-center text-sm font-medium text-white hover:opacity-80">Update
									Book</button>
							@else
								<button type="submit"
									class="rounded border-2 border-green-500 bg-green-600 py-2 px-3 text-center text-sm font-medium text-white hover:opacity-80">Save
									Book</button>
							@endif
						</div>
					</form>
				</div>

				{{-- <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
          </div> --}}

			</div>
		</div>
	</div>
	@if ($books->count() > 0)
		<table class="w-full table-auto border-collapse overflow-hidden rounded border border-white shadow">
			<thead>
				<tr class="px- border bg-green-600 text-left font-normal text-white">
					<th class="py-2 pl-2 font-normal">No</th>
					<th class="py-2 pl-2 font-normal">Author & Title</th>
					<th class="py-2 pl-2 font-normal">Genre</th>
					<th class="py-2 pl-2 font-normal">ISBN</th>
					<th class="py-2 pl-2 font-normal">Publisher</th>
					<th class="py-2 pl-2 font-normal">Published Date</th>
					<th class="py-2 pl-2 font-normal">Action</th>
				</tr>
			</thead>

			<tbody>
				@forelse ($books as $book)
					<tr class="border">
						<td class="p-2">{{ $loop->iteration }}</td>
						<td class="p-2">
							<div class="tt flex max-w-xs space-x-2 rounded border p-1 shadow-sm duration-300 hover:bg-green-50">
								<img src="{{ asset('/storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
									class="h-24 w-24 rounded object-cover object-center">
								<div class="space-y-2">
									<p class="font-semibold uppercase">{{ $book->title }}</p>
									<p class="text-xs font-medium capitalize text-gray-500">Author(s): {{ $book->authors }}</p>
								</div>
							</div>
						</td>
						<td class="p-2 uppercase">
							{{ $book->genre }}
						</td>
						<td class="p-2 uppercase">
							{{ $book->isbn }}
						</td>
						<td class="p-2">{{ $book->publisher }}</td>
						<td class="p-2">{{ $book->published_at->format('d M, Y') }}</td>
						<td class="items-center justify-start p-2">
							<button wire:click='edit({{ $book->id }})' title="Edit Book" data-toggle="tooltip" data-placement="left"
								class="mx-1 rounded-sm bg-blue-600 p-1 text-white transition duration-500 hover:opacity-80">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" class="bi bi-pencil-square"
									viewBox="0 0 16 16">
									<path
										d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
									<path fill-rule="evenodd"
										d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
								</svg>
							</button>
							<button wire:click="confirmDelete({{ $book->id }})" title="Delete Book" data-toggle="tooltip"
								data-placement="top"
								class="mx-1 rounded-sm bg-red-600 p-1 text-white transition duration-500 hover:opacity-80">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
								</svg>
							</button>
						</td>
					</tr>
				@empty
					<h2>No books yet in the shelf</h2>
				@endforelse

				<p class="my-2">{{ $books->links() }}</p>

			</tbody>
		</table>
	@else
		<p class="text-lg">No book, kindly add books</p>
	@endif
</div>
