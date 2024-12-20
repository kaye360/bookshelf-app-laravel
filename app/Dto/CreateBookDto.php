<?php
namespace App\Dto;

use App\Services\BookService;
use Illuminate\Support\Facades\Auth;

class CreateBookDto {

    public string $key;
    public string $title;
    public string $authors;
    public string $tags;
    public int $user_id;
    public bool $is_read;
    public bool $is_owned;
    public bool $is_favourite;
    public int $page_count;
    public ?string $cover_url;

    public function __construct( array $validated )
    {
        $this->key          = BookService::getKey( $validated['key'] );
        $this->title        = $validated['title'];
        $this->authors      = $this->getAuthors( $validated['authors']);
        $this->tags         = $this->getTagsFromInputs( $validated );
        $this->user_id      = Auth::user()->id;
        $this->is_read      = isset($validated['is_read']) && $validated['is_read'] === 'on';
        $this->is_owned     = isset($validated['is_owned']) && $validated['is_owned'] === 'on';
        $this->is_favourite = false;
        $this->page_count   = $validated['page_count'] ?? 0;
        $this->cover_url    = $validated['cover_url'] ?? null;
    }

    /**
     *
     * Convert the properties of this class to an assoc array
     *
     */
    public function toArray()
    {
        return get_object_vars( $this );
    }

    /**
     *
     * Extract author names into array
     *
     */
    private function getAuthors(string $authors) : string
    {
        $authors = json_decode($authors);
        $authors = array_map( fn($author) => (object) [
            'name' => $author->name,
            'key' => $author->key
        ], $authors);
        return json_encode($authors);
    }

    /**
     *
     * Extract tags from hidden user inputs
     *
     */
    private function getTagsFromInputs( array $validated )
    {
        $tags = array_filter( $validated, fn($key) => str_contains($key, 'tag'), ARRAY_FILTER_USE_KEY);
        $tags = array_values( $tags );
        $tags = BookService::formatTags( $tags );
        return json_encode( $tags );
    }

}
