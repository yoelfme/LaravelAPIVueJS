<?php

use App\Note;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{

    use DatabaseTransactions;

    protected $note = 'Esta es una nota'

    public function test_list_notes()
    {
        $category = factory(Category::class)->create();

        factory(Note::class)->times(2)->create([
            'category_id' => $category->id
        ]);

        $this->get('api/v1/notes')
            ->assertResponseOk()
            ->seeJsonEquals(Note::all()->toArray());

    }

    public function text_can_create_a_note()
    {
        $category = factory(Category::class)->create();
        $data = [
            'note' => $this->note,
            'category_id' => $category->id
        ];

        $this->post('api/v1/notes', $data);

        $this->seeInDatabase('notes', $data);

        $this->seeJsonEquals([
            'success' => true,
            'note' => Note::first()
        ]);

    }
}
