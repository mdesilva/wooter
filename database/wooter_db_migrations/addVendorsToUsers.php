<?php
namespace app\WooterMigration;

use Illuminate\Database\Seeder;

class AddVendorsToUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // converts vendors to users
        $sql = "
INSERT INTO users
(

   email,
   password,
   `key`,
   created_at,
   preselected_role


)
select

   email,
   pswd as password,
   salt as 'key',
   cdate as created_at,

   '3' as preselected_role

   from woozard_old_db.vendor as v
   where  NOT EXISTS( select u.email  as _email from users  as u   where   u.email = v.email COLLATE utf8_general_ci)   ;
";
        DB::connection()->getPdo()->exec($sql);

    }
}
