<?php

use Illuminate\Database\Seeder;
use App\Models\DbBlog\Article;
use App\Models\DbBlog\Tag;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, 50)->create();

        //关联article与tag
        $articles = Article::all();
        foreach ($articles as $article){
            $minId = Tag::query()->orderBy('id')->first()->id;
            $max = Tag::query()->count();
            $max = $max > 4 ? $max : 4;
            $rand = rand(1, $max-3) + $minId -1;
            $tagIdArray = [$rand, ($rand + 1), ($rand + 2)];

            $tags = Tag::whereIn('id',$tagIdArray)->get();
            $tagsJsonArray = [];
            foreach ($tags as $tag){
                $tagsJsonArray[] = [
                    'tg_id' => $tag->id,
                    'tag_name' => $tag->name,
                ];
                \DB::connection('db_blog')
                    ->table('article_tag_association')
                    ->insert([
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'article_id' => $article->id,
                        'tag_id' => $tag->id,
                    ]);
            }
            $tagsString = json_encode($tagsJsonArray, JSON_UNESCAPED_UNICODE);
            $article->tags = $tagsString;
            $article->save();
        }
    }
}
