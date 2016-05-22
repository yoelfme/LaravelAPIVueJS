<?php

use App\Note;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{

    use DatabaseTransactions;

    protected $note = 'Esta es una nota';

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

    public function test_can_create_a_note()
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
            'note' => Note::first()->toArray()
        ]);
    }

    public function test_validation_when_creating_a_note()
    {
        $category = factory(Category::class)->create();

        $data = [
            'note' => '',
            'category_id' => 100
        ];

        $this->post('api/v1/notes', $data, [
            'Accept' => 'application/json'
        ]);

        $this->dontSeeInDatabase('notes', $data);

        $this->seeJsonEquals([
            'success' => false,
            'errors' => [
                'The note field is required.',
                'The selected category id is invalid.'
            ]
        ]);
    }

    public function test_can_update_a_note()
    {
        $category = factory(Category::class)->create();
        $anotherCategory = factory(Category::class)->create();

        $note = factory(Note::class)->make();
        $category->notes()->save($note);

        $data = [
            'note' => $this->note,
            'category_id' => $anotherCategory->id
        ];

        $this->put('api/v1/notes/'.$note->id, $data);
        $this->seeInDatabase('notes', $data);

        $this->seeJsonEquals([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'note' => $this->note,
                'category_id' => $anotherCategory->id
            ]
        ]);
    }

    public function test_validation_when_updating_a_note()
    {
        $category = factory(Category::class)->create();

        $note = factory(Note::class)->make();
        $category->notes()->save($note);

        $data = [
            'note' => '',
            'category_id' => 100
        ];

        $this->put('api/v1/notes/'.$note->id, $data, [
            'Accept' => 'application/json'
        ]);

        $this->dontSeeInDatabase('notes', [
            'id' => $note->id,
            'note' => ''
        ]);

        $this->seeJsonEquals([
            'success' => false,
            'errors' => [
                'The note field is required.',
                'The selected category id is invalid.'
            ]
        ]);
    }

    public function test_can_delete_a_note()
    {
        $note = factory(Note::class)->create();

        $this->delete('api/v1/notes/'.$note->id, [], [
            'Accept' => 'application/json'
        ]);

        $this->dontSeeInDatabase('notes', [
            'id' => $note->id
        ]);

        $this->seeJsonEquals([
            'success' => true
        ]);
    }
}
