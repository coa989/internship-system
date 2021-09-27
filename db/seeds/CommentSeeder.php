<?php


use Phinx\Seed\AbstractSeed;

class CommentSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'MentorSeeder',
            'InternSeeder'
        ];
    }

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'body' => $faker->text(50),
                'mentor_id' => $faker->numberBetween(1, 10),
                'intern_id' => $faker->numberBetween(1, 50),
            ];
        }
        
        $this->table('comments')->insert($data)->saveData();
    }
}
