<?php


use Phinx\Seed\AbstractSeed;

class InternSeeder extends AbstractSeed
{
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
        for ($i = 0; $i < 25; $i++) {
            $data[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'group_id' => $faker->numberBetween(1, 5)
            ];
        }

        $this->table('interns')->insert($data)->saveData();
    }
}
