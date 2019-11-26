<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/news.json");
        $data = json_decode($json);

        foreach ($data as $obj) {

            DB::table('news')->insert([
                'title' => $obj->title,
                'image' => $obj->image,
                'description' => $obj->description,
                'body' => $obj->body,
                'author' => $obj->author,
                'url' => $obj->url,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
