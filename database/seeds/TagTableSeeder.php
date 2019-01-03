<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/2
 * Time: 21:11
 */

use Illuminate\Database\Seeder;
use App\Models\DbBlog\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 20)->create();
    }
}
