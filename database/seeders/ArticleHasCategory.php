<?php

namespace Database\Seeders;

use App\Models\AbArticle;
use App\Models\AbArticleHasCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleHasCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/article_has_articlecategory.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                AbArticleHasCategory::create([
                    "ab_articlecategory_id" => $data[0],
                    "ab_article_id" => $data[1]
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
