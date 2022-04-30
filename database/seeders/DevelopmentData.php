<?php

namespace Database\Seeders;

use App\Models\AbArticle;
use App\Models\AbArticleCategory;
use App\Models\AbUser;
use Illuminate\Database\Seeder;


class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var boolean|resource $csvFile */
        $csvFile = fopen(base_path("database/data/user.csv"), "r"); //create resource
        $firstline = true; //ignore first line

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                AbUser::create([
                    "ab_name" => $data['1'],
                    "ab_password" => $data['2'],
                    "ab_mail" => $data['2'],

                ]);
            }
            $firstline = false;
        }
        fclose($csvFile); //close resource


        $csvFile = fopen(base_path("database/data/articles.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                AbArticle::create([
                    "ab_name" => $data['1'],
                    "ab_price" => (int)$data['2'],
                    "ab_description" => $data['3'],
                    "ab_creator_id" => $data['4'],
                    "ab_createdate" => \DateTime::createFromFormat('m.d.y H:m', $data['5'])
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
        $csvFile = fopen(base_path("database/data/articlecategory.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                $data['2'] = $data['2'] != 'NULL' ? (int)$data['2'] : null; // convert to null if false, else value
                AbArticleCategory::create([
                    "ab_name" => $data['1'],
                    "ab_parent" => $data['2'],

                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
