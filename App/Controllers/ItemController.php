<?php
namespace App\Controllers;

use Controller, Request, View;

class ItemController extends Controller {

    private $sql = "SELECT
        i.*,
        GROUP_CONCAT(c.name) AS categories

        FROM items AS i

        LEFT JOIN item_category AS ic ON i.id = ic.item_id
        LEFT JOIN categories AS c ON c.id = ic.category_id

        GROUP BY i.id";

    // Multiple items view
    public function index(Request $data){
        return View::make('item.index', [
            'items' => $this->query($this->sql, 'Item')->fetchAll(),
        ]);
    }

    private function get_single($id){
        $sql = $this->sql;
        $sql .= 'WHERE i.id = :id';

        return $this->query($sql, [
            'id' => $id,
        ],'Item')->fetch();
    }

    // Single item view
    public function item(Request $data){
        return View::make('item.item', [
            'item' => $this->get_single($data->post->id),
        ]);
    }

    // Edit item view
    public function edit(Request $data){
        return View::make('item.edit', [
            'item' => $this->get_single($data->post->id),
        ]);
    }

    // Create a new item
    public function put(Request $data){
        return [$data];
    }

    // Edit an item
    public function patch(Request $data){
        return [$data];
    }

    // Delete an item
    public function delete(Request $data){
        return [$data];
    }

}
